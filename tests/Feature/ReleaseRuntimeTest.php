<?php

namespace Tests\Feature;

use App\Support\PublicContent;
use Illuminate\Support\Facades\{Cache, DB, Route};
use Tests\TestCase;

class ReleaseRuntimeTest extends TestCase
{
    public function test_liveness_does_not_need_database_or_cache(): void
    {
        DB::shouldReceive('select')->never();
        Cache::shouldReceive('store')->never();
        $this->getJson('/health/live')->assertOk()->assertExactJson(['status' => 'ok'])->assertHeader('Cache-Control', 'no-store, private');
    }

    public function test_readiness_checks_database_writable_paths_and_cache(): void
    {
        config(['public_site.cache_store' => 'array', 'release.writable_paths' => [sys_get_temp_dir()]]);
        DB::shouldReceive('select')->once()->with('SELECT 1')->andReturn([(object) ['1' => 1]]);
        $this->getJson('/health/ready')->assertOk()->assertExactJson(['status' => 'ok']);
        $this->assertSame([], Cache::store('array')->all());
    }

    public function test_database_failure_returns_only_safe_readiness_status(): void
    {
        DB::shouldReceive('select')->andThrow(new \RuntimeException('private password and database host'));
        $this->getJson('/health/ready')->assertStatus(503)->assertExactJson(['status' => 'unavailable']);
    }

    public function test_missing_storage_fails_readiness(): void
    {
        DB::shouldReceive('select')->andReturn([]);
        config(['release.writable_paths' => ['/nonexistent-bulsca-storage']]);
        $this->getJson('/health/ready')->assertStatus(503)->assertExactJson(['status' => 'unavailable']);
    }

    public function test_cache_failure_fails_readiness_without_exposing_details(): void
    {
        DB::shouldReceive('select')->andReturn([]);
        config(['release.writable_paths' => []]);
        Cache::shouldReceive('store')->andThrow(new \RuntimeException('private cache path'));
        $this->getJson('/health/ready')->assertStatus(503)->assertExactJson(['status' => 'unavailable']);
    }

    public function test_public_urls_use_api_origin_while_sso_retains_portal_origin(): void
    {
        config(['app.url' => 'https://portal.bulsca.co.uk', 'public_site.api_url' => 'https://api.bulsca.co.uk/']);
        $this->assertSame('https://api.bulsca.co.uk/img/portraits/a.jpg', PublicContent::image('portraits/a.jpg'));
        $this->assertSame('https://api.bulsca.co.uk/storage/a.pdf', PublicContent::image('public/a.pdf'));
        $this->assertSame('https://api.bulsca.co.uk/api/v1/resources/123/file', PublicContent::url(route('api.v1.resources.file', ['id' => 123], false)));
        $this->assertSame('https://external.example/a.png', PublicContent::image('https://external.example/a.png'));
    }

    public function test_only_trusted_proxies_can_supply_https_host_and_client_address(): void
    {
        Route::get('/test-proxy', fn () => ['secure' => request()->secure(), 'host' => request()->getHost(), 'ip' => request()->ip()]);
        config(['release.trusted_proxies' => ['10.89.40.0/24']]);
        $headers = ['HTTP_X_FORWARDED_PROTO' => 'https', 'HTTP_X_FORWARDED_HOST' => 'portal.bulsca.co.uk', 'HTTP_X_FORWARDED_FOR' => '203.0.113.7'];
        $this->withServerVariables($headers + ['REMOTE_ADDR' => '10.89.40.2'])->getJson('http://localhost/test-proxy')->assertJson(['secure' => true, 'host' => 'portal.bulsca.co.uk', 'ip' => '203.0.113.7']);
        $this->withServerVariables($headers + ['REMOTE_ADDR' => '198.51.100.2'])->getJson('http://localhost/test-proxy')->assertJson(['secure' => false, 'host' => 'localhost', 'ip' => '198.51.100.2']);
    }

    public function test_portal_sso_redirect_and_session_cookie_keep_the_portal_origin(): void
    {
        \Illuminate\Support\Facades\Http::preventStrayRequests();
        config(['release.trusted_proxies' => ['10.89.40.0/24'], 'sso.enabled' => true, 'sso.auth_server' => 'https://auth.example.test', 'sso.client_id' => 'test-client', 'sso.redirect_uri' => 'https://portal.bulsca.co.uk/auth/sso/callback', 'session.secure' => true, 'session.domain' => null]);
        $response = $this->withServerVariables(['REMOTE_ADDR' => '10.89.40.2', 'HTTP_X_FORWARDED_PROTO' => 'https'])->get('http://portal.bulsca.co.uk/auth/sso');
        $response->assertRedirect();
        $location = $response->headers->get('Location');
        $this->assertSame('auth.example.test', parse_url($location, PHP_URL_HOST));
        parse_str(parse_url($location, PHP_URL_QUERY), $query);
        $this->assertSame('https://portal.bulsca.co.uk/auth/sso/callback', $query['redirect_uri']);
        $cookie = collect($response->headers->getCookies())->first(fn ($cookie) => $cookie->getName() === config('session.cookie'));
        $this->assertNotNull($cookie);
        $this->assertTrue($cookie->isSecure());
        $this->assertTrue($cookie->isHttpOnly());
        $this->assertNull($cookie->getDomain());
        $this->assertSame('lax', $cookie->getSameSite());
        \Illuminate\Support\Facades\Http::assertNothingSent();
    }
}
