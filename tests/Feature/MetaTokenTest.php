<?php

namespace Tests\Feature;

use App\Services\{MetaContentService, MetaTokenStore};
use Illuminate\Support\Facades\{Crypt, Http};
use Tests\TestCase;

class MetaTokenTest extends TestCase
{
    private string $directory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->directory = sys_get_temp_dir().'/bulsca-token-'.bin2hex(random_bytes(8));
        mkdir($this->directory, 0700);
        config(['services.meta.token_path' => $this->directory.'/token.enc', 'services.meta.access_token' => 'initial-private-token', 'services.meta.user_id' => 'test-user', 'services.meta.app_id' => 'test-app', 'services.meta.app_secret' => 'private-app-secret', 'public_site.cache_store' => 'array']);
        Http::preventStrayRequests();
    }

    protected function tearDown(): void
    {
        foreach (glob($this->directory.'/*') as $file) unlink($file);
        rmdir($this->directory);
        parent::tearDown();
    }

    public function test_tokens_are_encrypted_private_and_survive_a_new_service_instance(): void
    {
        $store = new MetaTokenStore;
        $this->assertSame('initial-private-token', $store->get());
        $store->put('renewed-private-token', 3600);
        $file = config('services.meta.token_path');
        $this->assertStringNotContainsString('renewed-private-token', file_get_contents($file));
        $this->assertSame(0600, fileperms($file) & 0777);
        $this->assertSame('renewed-private-token', (new MetaTokenStore)->get());
    }

    public function test_successful_refresh_is_consumed_by_public_and_legacy_readers(): void
    {
        Http::fake([
            '*oauth/access_token*' => Http::response(['access_token' => 'renewed-private-token', 'expires_in' => 3600]),
            '*test-user/media*' => Http::response(['data' => []]),
        ]);
        $this->artisan('meta:refresh-token')->assertSuccessful();
        $this->getJson('/api/v1/social/posts')->assertOk();
        Http::assertSent(fn ($request) => str_contains($request->url(), '/test-user/media') && $request['access_token'] === 'renewed-private-token');
        (new MetaContentService)->getLatestPosts();
        Http::assertSentCount(3);
        Http::assertNotSent(fn ($request) => str_contains($request->url(), '/test-user/media') && $request['access_token'] !== 'renewed-private-token');
    }

    public function test_failed_exchange_retains_previous_token_and_does_not_leak_secrets(): void
    {
        $store = new MetaTokenStore;
        $store->put('last-good-token', 3600);
        Http::fake(['*' => Http::response(['error' => 'private-provider-error'], 503)]);
        $this->artisan('meta:refresh-token')->expectsOutput('Token refresh failed; check provider configuration and private storage.')->assertFailed();
        $this->assertSame('last-good-token', $store->get());
    }

    public function test_invalid_exchange_payload_cannot_replace_last_good_token(): void
    {
        (new MetaTokenStore)->put('last-good-token', 3600);
        Http::fake(['*' => Http::response(['access_token' => '', 'expires_in' => 3600])]);
        $this->artisan('meta:refresh-token')->assertFailed();
        $this->assertSame('last-good-token', (new MetaTokenStore)->get());
    }

    public function test_expired_stored_token_does_not_revert_to_old_environment_token(): void
    {
        file_put_contents(config('services.meta.token_path'), Crypt::encryptString(json_encode(['access_token' => 'expired', 'expires_at' => time() - 1])));
        $this->assertNull((new MetaTokenStore)->get());
        $this->artisan('meta:refresh-token')->assertFailed();
        Http::assertNothingSent();
    }

    public function test_corrupt_store_returns_a_safe_public_failure(): void
    {
        file_put_contents(config('services.meta.token_path'), 'private-corrupt-data');
        $this->getJson('/api/v1/social/posts')->assertStatus(500)->assertDontSee('private-corrupt-data');
        Http::assertNothingSent();
    }

    public function test_unconfigured_social_integration_does_not_contact_provider(): void
    {
        config(['services.meta.user_id' => null]);
        $this->artisan('meta:refresh-token')->assertSuccessful();
        Http::assertNothingSent();
    }
}
