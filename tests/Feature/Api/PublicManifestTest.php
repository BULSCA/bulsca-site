<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Services\{PublicContentRevision, PublicRouteManifest};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Tests\Support\PublicSiteFixture;
use Tests\TestCase;

class PublicManifestTest extends TestCase
{
    use DatabaseMigrations;

    private array $data;
    private PublicContentRevision $revisions;
    private PublicRouteManifest $manifest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(now()->setDate(2026, 10, 28)->startOfDay());
        Storage::fake('local');
        config(['filesystems.default' => 'local', 'public_site.cache_store' => 'array']);
        // These tests are not about throttling; keep them out of the shared suite bucket.
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        $this->revisions = app(PublicContentRevision::class);
        $this->manifest = app(PublicRouteManifest::class);
        $this->data = PublicSiteFixture::create();
    }

    /** @return list<string> */
    private function urls(): array
    {
        return array_column($this->manifest->routes(), 'url');
    }

    public function test_routes_are_unique_and_sorted(): void
    {
        $urls = $this->urls();
        $this->assertSame($urls, array_values(array_unique($urls)));
        $sorted = $urls;
        sort($sorted);
        $this->assertSame($sorted, $urls);
    }

    public function test_lists_informational_pages(): void
    {
        $urls = $this->urls();
        foreach (['/', '/freshers', '/competitions', '/competitions/championships', '/get-involved', '/resources', '/about', '/about/records', '/contact', '/contact-form', '/latest', '/privacy', '/terms-of-service', '/cookies', '/welfare'] as $url) {
            $this->assertContains($url, $urls);
        }
    }

    public function test_lists_articles_and_tag_pages(): void
    {
        $article = $this->data['article'];
        $this->assertContains('/article/test-public-news.'.$article->id, $this->urls());
        $this->assertNotContains('/articles/tag/news', $this->urls());
        $article->tags()->attach(Tag::create(['name' => 'News', 'slug' => 'news']));
        $this->assertContains('/articles/tag/news', $this->urls());
    }

    public function test_lists_clubs_committees_and_members(): void
    {
        $urls = $this->urls();
        $this->assertContains('/get-involved/clubs/test-university.'.$this->data['club']->id, $urls);
        $this->assertNotContains('/get-involved/clubs/inactive-university.'.$this->data['inactive']->id, $urls);
        $this->assertContains('/get-involved/committee/2026-27', $urls);
        $this->assertContains('/get-involved/committee/2025-26', $urls);
        $this->assertContains('/get-involved/committee/2026-27/test-volunteer', $urls);
    }

    public function test_lists_seasons_championships_and_competitions(): void
    {
        $urls = $this->urls();
        $this->assertContains('/competitions/league/2026-27', $urls);
        $this->assertContains('/competitions/league/2025-26', $urls);
        $this->assertContains('/competitions/championships/2023', $urls);
        $this->assertContains('/competitions/championships/2026', $urls);
        $this->assertContains('/competitions/test-university-2026.'.$this->data['comp']->id, $urls);
    }

    public function test_lists_resource_pages_downloads_sercs_and_casualties(): void
    {
        $urls = $this->urls();
        $this->assertContains('/resources/competition-documents', $urls);
        $this->assertContains('/resources/view/'.$this->data['resource']->id, $urls);
        $this->assertNotContains('/resources/view/'.$this->data['orphan']->id, $urls);
        $this->assertContains('/resources/sercs/pool-practice.'.$this->data['serc']->id, $urls);
        $this->assertContains('/resources/casualties/test-casualty.'.$this->data['casualty']->id, $urls);
    }

    public function test_removed_or_unpublished_content_disappears(): void
    {
        $article = $this->data['article'];
        $article->delete();
        $this->assertNotContains('/article/test-public-news.'.$article->id, $this->urls());
        $this->data['club']->update(['active' => false]);
        $this->assertNotContains('/get-involved/clubs/test-university.'.$this->data['club']->id, $this->urls());
    }

    public function test_route_metadata_uses_expected_kinds(): void
    {
        $byUrl = collect($this->manifest->routes())->keyBy('url');
        $this->assertSame('page', $byUrl['/about']['kind']);
        $this->assertSame('article', $byUrl['/article/test-public-news.'.$this->data['article']->id]['kind']);
        $this->assertSame('Test University', $byUrl['/get-involved/clubs/test-university.'.$this->data['club']->id]['title']);
    }

    public function test_manifest_endpoint_is_public_and_deterministic(): void
    {
        $first = $this->getJson('/api/v1/manifest')->assertOk();
        $second = $this->getJson('/api/v1/manifest')->assertOk();
        $this->assertSame($first->getContent(), $second->getContent());
        $this->assertIsInt($first->json('data.revision'));
        $this->assertIsArray($first->json('data.routes'));
    }

    public function test_manifest_reads_do_not_change_the_revision(): void
    {
        $before = $this->revisions->current();
        $this->getJson('/api/v1/manifest')->assertOk();
        $this->getJson('/api/v1/manifest')->assertOk();
        $this->assertSame($before, $this->revisions->current());
    }

    public function test_revision_change_publishes_updated_route_list(): void
    {
        $first = $this->getJson('/api/v1/manifest')->assertOk()->json('data');
        $article = $this->data['article'];
        $article->delete();
        $second = $this->getJson('/api/v1/manifest')->assertOk()->json('data');
        $this->assertSame($first['revision'] + 1, $second['revision']);
        $this->assertNotContains('/article/test-public-news.'.$article->id, array_column($second['routes'], 'url'));
    }

    public function test_stale_manifest_cache_does_not_survive_a_revision_change(): void
    {
        $this->getJson('/api/v1/manifest')->assertOk();
        $article = $this->data['article'];
        Model::unguarded(function () use ($article) {
            $article->update(['title' => 'Fresh headline']);
        });
        $routes = array_column($this->getJson('/api/v1/manifest')->assertOk()->json('data.routes'), 'url');
        $this->assertContains('/article/fresh-headline.'.$article->id, $routes);
        $this->assertNotContains('/article/test-public-news.'.$article->id, $routes);
    }
}
