<?php

namespace Tests\Feature\Api;

use App\Mail\{ContactFormConfirmation, ContactFormSubmission};
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Cache, Http, Mail};
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicActionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.turnstile.site_key' => 'test-public-key', 'services.turnstile.secret_key' => 'test-private-key', 'public_site.cache_store' => 'array']);
        Http::preventStrayRequests();
        Mail::fake();
    }

    private function contact(): array
    {
        return ['name' => 'Test Visitor', 'email' => 'visitor@example.test', 'department' => 'welfare', 'subject' => 'Test question', 'message' => 'Test message', 'cf-turnstile-response' => 'test-token'];
    }

    public function test_contact_config_contains_no_secret_and_can_disable_submission(): void
    {
        $this->getJson('/api/v1/contact/config')->assertOk()->assertJsonPath('data.accepts_submissions', true)->assertDontSee('test-private-key');
        config(['services.turnstile.secret_key' => null]);
        $this->getJson('/api/v1/contact/config')->assertOk()->assertJsonPath('data.accepts_submissions', false);
        $this->postJson('/api/v1/contact/submissions', $this->contact())->assertStatus(503);
        Mail::assertNothingSent();
    }

    public function test_valid_contact_sends_to_the_selected_department_and_confirms(): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true])]);
        $this->postJson('/api/v1/contact/submissions', $this->contact())->assertCreated()->assertJsonStructure(['data' => ['message']]);
        $this->assertDatabaseHas('contact_submissions', ['email' => 'visitor@example.test', 'recipient_department' => 'welfare']);
        Mail::assertSent(ContactFormSubmission::class, fn ($mail) => $mail->hasTo('welfare@bulsca.co.uk'));
        Mail::assertSent(ContactFormConfirmation::class, fn ($mail) => $mail->hasTo('visitor@example.test'));
        Http::assertSent(fn ($request) => $request['secret'] === 'test-private-key' && $request['response'] === 'test-token');
    }

    public function test_validation_and_captcha_failure_do_not_store_or_send(): void
    {
        $this->postJson('/api/v1/contact/submissions', array_merge($this->contact(), ['department' => 'attacker@example.test']))->assertUnprocessable()->assertJsonValidationErrors('department');
        Http::assertNothingSent();
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => false])]);
        $this->postJson('/api/v1/contact/submissions', $this->contact())->assertUnprocessable()->assertJsonValidationErrors('cf-turnstile-response');
        $this->assertDatabaseCount('contact_submissions', 0);
        Mail::assertNothingSent();
    }

    public function test_captcha_provider_failure_returns_safe_error_and_no_side_effects(): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['secret' => 'provider-private-value'], 503)]);
        $response = $this->postJson('/api/v1/contact/submissions', $this->contact())->assertStatus(500)->assertDontSee('provider-private-value')->assertDontSee('test-private-key');
        $this->assertSame($response->json('request_id'), $response->headers->get('X-Request-ID'));
        $this->assertDatabaseCount('contact_submissions', 0);
        Mail::assertNothingSent();
    }

    public function test_contact_submission_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) $this->postJson('/api/v1/contact/submissions', [])->assertUnprocessable();
        $this->postJson('/api/v1/contact/submissions', [])->assertStatus(429);
    }

    public function test_article_views_do_not_consume_the_contact_submission_limit(): void
    {
        $article = Article::factory()->create();
        for ($i = 0; $i < 6; $i++) $this->postJson('/api/v1/articles/'.$article->id.'/views', ['event_id' => (string) Str::uuid()])->assertOk();
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true])]);
        $this->postJson('/api/v1/contact/submissions', $this->contact())->assertCreated();
    }

    public function test_mail_failure_has_an_uncertain_safe_outcome_without_replaying_delivery(): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true])]);
        Mail::shouldReceive('to')->once()->with('welfare@bulsca.co.uk')->andReturnSelf();
        Mail::shouldReceive('send')->once()->andThrow(new \RuntimeException('private SMTP credentials'));
        $this->postJson('/api/v1/contact/submissions', $this->contact())->assertStatus(500)->assertDontSee('private SMTP');
        $this->assertDatabaseCount('contact_submissions', 1);
    }

    public function test_notices_preserve_admin_content_with_allowlist_sanitization(): void
    {
        $this->getJson('/api/v1/notice')->assertOk()->assertJsonPath('data', null);
        \Illuminate\Support\Facades\DB::table('global_notifications')->insert(['type' => 'GLOBAL_BANNER', 'title' => 'Notice', 'content' => '<p>Published notice</p><script>private()</script>']);
        $this->getJson('/api/v1/notice')->assertOk()->assertJsonPath('data.heading', 'Notice')->assertJsonPath('data.html', '<p>Published notice</p>');
    }

    public function test_views_and_ratings_are_atomic_idempotent_and_do_not_change_article_dates(): void
    {
        $article = Article::factory()->create(['views' => 0, 'thumbs_up' => 0, 'thumbs_down' => 0]);
        $updated = $article->fresh()->updated_at;
        $event = ['event_id' => (string) Str::uuid()];
        $this->postJson('/api/v1/articles/'.$article->id.'/views', $event)->assertOk()->assertJsonPath('data.views', 1);
        $this->postJson('/api/v1/articles/'.$article->id.'/views', $event)->assertOk()->assertJsonPath('data.views', 1);
        $vote = ['event_id' => (string) Str::uuid(), 'type' => 'up'];
        $this->postJson('/api/v1/articles/'.$article->id.'/ratings', $vote)->assertOk()->assertJsonPath('data.thumbs_up', 1);
        $this->postJson('/api/v1/articles/'.$article->id.'/ratings', array_merge($vote, ['type' => 'down']))->assertOk()->assertJsonPath('data.thumbs_down', 0);
        $this->postJson('/api/v1/articles/'.$article->id.'/ratings', ['event_id' => (string) Str::uuid(), 'type' => 'down'])->assertOk()->assertJsonPath('data.thumbs_down', 1);
        $this->assertTrue($updated->equalTo($article->fresh()->updated_at));
        $this->postJson('/api/v1/articles/'.$article->id.'/ratings', ['event_id' => 'invalid', 'type' => 'other'])->assertUnprocessable();
        $this->postJson('/api/v1/articles/missing/views', ['event_id' => (string) Str::uuid()])->assertNotFound();
    }

    public function test_presentation_is_database_independent_and_social_failure_retains_safe_cache(): void
    {
        $this->getJson('/api/v1/presentation')->assertOk()->assertJsonStructure(['data' => ['version', 'banner_pool', 'banner_overrides', 'campaigns']]);
        config(['services.meta.user_id' => 'test-provider-user', 'services.meta.access_token' => 'private-token']);
        Http::fake(['graph.facebook.com/*' => Http::sequence()->push(['data' => [['id' => '1', 'caption' => 'Public update', 'permalink' => 'https://example.test/post', 'media_url' => 'https://example.test/image.jpg']]])->push([], 503)->push([], 503)]);
        $this->getJson('/api/v1/social/posts')->assertOk()->assertJsonPath('data.0.summary', 'Public update')->assertDontSee('private-token');
        $cached = Cache::store('array')->get('public-social');
        $cached['refresh_after'] = 0;
        Cache::store('array')->put('public-social', $cached, 60);
        $this->getJson('/api/v1/social/posts')->assertOk()->assertJsonPath('stale', true)->assertJsonPath('data.0.summary', 'Public update');
        Cache::store('array')->forget('public-social');
        $this->getJson('/api/v1/social/posts')->assertStatus(500)->assertDontSee('private-token');
    }
}
