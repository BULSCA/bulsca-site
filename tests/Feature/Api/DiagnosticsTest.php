<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use RuntimeException;
use Tests\TestCase;

class DiagnosticsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $store = new \Illuminate\Cache\Repository(new \Illuminate\Cache\ArrayStore);
        Cache::shouldReceive('store')->with('file')->andReturn($store);
    }

    public function test_api_errors_have_safe_messages_matching_ids_and_one_log(): void
    {
        Route::get('/api/v1/test-failure', fn () => throw new RuntimeException('password=private'));
        $logger = \Mockery::mock(\Psr\Log\LoggerInterface::class);
        Log::shouldReceive('channel')->with('diagnostics')->once()->andReturn($logger);
        $logger->shouldReceive('error')->once()->with('api_failure', \Mockery::on(fn ($context) => isset($context['request_id']) && ! str_contains(json_encode($context), 'private')));
        $response = $this->withHeader('X-Request-ID', 'caller-controlled')->getJson('/api/v1/test-failure')
            ->assertStatus(500)->assertJsonPath('code', 'service_unavailable');
        $this->assertSame($response->json('request_id'), $response->headers->get('X-Request-ID'));
        $this->assertNotSame('caller-controlled', $response->json('request_id'));
        $this->assertStringNotContainsString('private', $response->getContent());
    }

    private function report(): array
    {
        return ['app' => 'public', 'app_version' => 'dev', 'event_id' => (string) Str::uuid(),
            'category' => 'network', 'message' => 'Request failed', 'route_template' => '/article/:slug'];
    }

    public function test_reports_use_no_database_and_discard_unapproved_fields(): void
    {
        DB::shouldReceive('connection')->never();
        $logger = \Mockery::mock(\Psr\Log\LoggerInterface::class);
        Log::shouldReceive('channel')->with('diagnostics')->andReturn($logger);
        $logger->shouldReceive('warning')->once()->with('client_error', \Mockery::on(fn ($data) => ! array_key_exists('token', $data)));
        $this->postJson('/api/v1/client-errors', $this->report() + ['token' => 'secret'])->assertStatus(202);
    }

    public function test_unsafe_report_messages_and_routes_are_rejected(): void
    {
        $this->postJson('/api/v1/client-errors', array_merge($this->report(), ['message' => 'password=private', 'route_template' => '/?token=secret']))
            ->assertUnprocessable()->assertJsonValidationErrors(['message', 'route_template']);
    }

    public function test_oversized_reports_are_rejected(): void
    {
        $this->postJson('/api/v1/client-errors', $this->report() + ['extra' => str_repeat('x', 9000)])->assertStatus(413);
    }

    public function test_throttling_returns_retry_after_and_logger_failures_are_controlled(): void
    {
        $logger = \Mockery::mock(\Psr\Log\LoggerInterface::class);
        Log::shouldReceive('channel')->with('diagnostics')->andReturn($logger);
        $logger->shouldReceive('warning')->andThrow(new RuntimeException('logger unavailable'));
        for ($i = 0; $i < 30; $i++) {
            $this->postJson('/api/v1/client-errors', $this->report())->assertStatus(503);
        }
        $this->postJson('/api/v1/client-errors', $this->report())->assertStatus(429)->assertHeader('Retry-After');
    }
}
