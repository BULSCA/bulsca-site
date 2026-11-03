<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Http, Log};
use Tests\TestCase;

class PortalAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['sso.enabled' => true, 'sso.auth_server' => 'https://identity.example.test', 'sso.client_id' => 'test-client', 'sso.client_secret' => 'secret-never-log']);
        Http::preventStrayRequests();
    }

    public function test_sso_starts_with_a_random_state_and_keeps_secrets_out_of_the_redirect(): void
    {
        $first = $this->get('/auth/sso?portal=1')->assertRedirect();
        $state = session('sso_state');
        $this->assertSame(40, strlen($state));
        $this->assertTrue(session('sso_portal'));
        $this->assertStringContainsString('state='.$state, $first->headers->get('Location'));
        $this->assertStringNotContainsString('secret-never-log', $first->headers->get('Location'));
        $this->get('/auth/sso?portal=1');
        $this->assertNotSame($state, session('sso_state'));
    }

    public function test_missing_wrong_and_array_states_are_rejected_before_contacting_sso(): void
    {
        $this->get('/auth/sso/callback?code=private-code')->assertRedirect('/login');
        $this->withSession(['sso_state' => 'valid', 'sso_portal' => true])->get('/auth/sso/callback?state=wrong&code=private-code')->assertRedirect('/?auth=failed')->assertSessionMissing('sso_state');
        $this->withSession(['sso_state' => 'valid'])->get('/auth/sso/callback?state[]=valid&code=private-code')->assertRedirect('/login');
        Http::assertNothingSent();
        $this->assertGuest();
    }

    public function test_callback_creates_only_an_account_regenerates_the_session_and_is_single_use(): void
    {
        Log::shouldReceive('info')->never();
        Http::fake([
            'identity.example.test/sso/token' => Http::response(['access_token' => 'private-access', 'refresh_token' => 'private-refresh']),
            'identity.example.test/sso/validate' => Http::response(['user' => ['id' => 82, 'name' => 'Committee Person', 'email' => 'person@example.test']]),
            'identity.example.test/sso/logout' => Http::response([]),
        ]);
        $this->withSession(['sso_state' => 'valid', 'sso_portal' => true]);
        $previous = session()->getId();
        $this->get('/auth/sso/callback?state=valid&code=private-code')->assertRedirect('/dashboard')->assertSessionMissing('sso_state');
        $user = User::where('sso_user_id', 82)->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($previous, session()->getId());
        $this->assertFalse($user->hasRole('super_admin'));
        $this->assertDatabaseCount('portal_memberships', 0);
        $this->getJson('/api/v1/portal/me')->assertOk()->assertJsonCount(0, 'data.organisations');
        Http::assertSentCount(2);
        $this->postJson('/api/v1/portal/logout')->assertOk();
        $this->get('/auth/sso/callback?state=valid&code=private-code')->assertRedirect('/login');
        Http::assertSentCount(3);
    }

    public function test_provider_failure_does_not_log_response_bodies_codes_or_tokens(): void
    {
        Log::shouldReceive('warning')->once()->with('sso_token_unavailable', ['status' => 503]);
        Http::fake(['identity.example.test/sso/token' => Http::response(['access_token' => 'private-access', 'email' => 'private@example.test'], 503)]);
        $this->withSession(['sso_state' => 'valid', 'sso_portal' => true])->get('/auth/sso/callback?state=valid&code=private-code')->assertRedirect('/?auth=failed')->assertSessionMissing('sso_state');
        $this->assertGuest();
    }

    public function test_invalid_provider_profile_is_rejected_without_an_account(): void
    {
        Log::shouldReceive('warning')->once()->with('sso_profile_unavailable', ['status' => 200]);
        Http::fake([
            'identity.example.test/sso/token' => Http::response(['access_token' => 'private-access']),
            'identity.example.test/sso/validate' => Http::response(['user' => ['id' => [], 'name' => 'Person', 'email' => 'not-an-email']]),
        ]);
        $this->withSession(['sso_state' => 'valid'])->get('/auth/sso/callback?state=valid&code=private-code')->assertRedirect('/login');
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_portal_logout_clears_local_session_even_when_provider_is_unavailable(): void
    {
        Log::shouldReceive('warning')->once()->with('sso_logout_unavailable');
        Http::fake(['identity.example.test/sso/logout' => Http::failedConnection('secret-never-log')]);
        $user = User::factory()->create(['auth_type' => 'sso']);
        $this->actingAs($user)->withSession(['sso_access_token' => 'private-access', 'sso_refresh_token' => 'private-refresh'])
            ->postJson('/api/v1/portal/logout')->assertOk()->assertJsonPath('data.signed_out', true)
            ->assertSessionMissing('sso_access_token')->assertSessionMissing('sso_refresh_token');
        $this->assertGuest();
    }

    public function test_private_data_and_errors_cannot_be_cached(): void
    {
        $guest = $this->getJson('/api/v1/portal/me')->assertUnauthorized();
        $this->assertStringContainsString('no-store', $guest->headers->get('Cache-Control'));
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/v1/portal/me')->assertOk();
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('Cookie', $response->headers->get('Vary'));
    }
}
