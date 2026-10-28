<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        config(['sso.enabled' => true]);
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_legacy_login_screen_can_be_rendered(): void
    {
        $this->get('/login/legacy')->assertOk()->assertViewIs('auth.login');
    }

    public function test_login_redirects_to_legacy_when_sso_is_disabled(): void
    {
        config(['sso.enabled' => false]);

        $this->get('/login')->assertRedirect(route('login.legacy'));
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login/legacy', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->post('/login/legacy', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}
