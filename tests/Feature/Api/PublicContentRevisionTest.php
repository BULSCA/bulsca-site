<?php

namespace Tests\Feature\Api;

use App\Services\PublicContentRevision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Support\PublicSiteFixture;
use Tests\TestCase;

class PublicContentRevisionTest extends TestCase
{
    use DatabaseMigrations;

    private array $data;
    private PublicContentRevision $revisions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(now()->setDate(2026, 10, 28)->startOfDay());
        config(['public_site.cache_store' => 'array']);
        // These tests are not about throttling; keep them out of the shared suite bucket.
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        $this->revisions = app(PublicContentRevision::class);
        $this->data = PublicSiteFixture::create();
    }

    public function test_committed_content_writes_bump_the_revision(): void
    {
        $before = $this->revisions->current();
        Model::unguarded(function () {
            $this->data['article']->update(['title' => 'Updated headline']);
        });
        $this->assertSame($before + 1, $this->revisions->current());
        Model::unguarded(function () {
            $this->data['serc']->update(['name' => 'Renamed scenario']);
        });
        $this->assertSame($before + 2, $this->revisions->current());
    }

    public function test_rolled_back_write_does_not_bump(): void
    {
        $before = $this->revisions->current();
        DB::beginTransaction();
        Model::unguarded(function () {
            $this->data['article']->update(['title' => 'Rolled back']);
        });
        DB::rollBack();
        $this->assertSame($before, $this->revisions->current());
        $this->assertSame('Test public news', $this->data['article']->fresh()->title);
    }

    public function test_write_after_rollback_still_bumps(): void
    {
        $before = $this->revisions->current();
        DB::beginTransaction();
        $this->data['serc']->delete();
        DB::rollBack();
        $this->assertSame($before, $this->revisions->current());
        Model::unguarded(function () {
            $this->data['article']->update(['title' => 'After rollback']);
        });
        $this->assertSame($before + 1, $this->revisions->current());
    }

    public function test_read_only_counter_changes_do_not_bump(): void
    {
        $before = $this->revisions->current();
        $article = $this->data['article'];
        // The same Eloquent counter save the legacy article page performs on every view.
        $article->views = $article->views + 1;
        $article->save();
        // The new interaction endpoint reports views through an atomic increment.
        $this->postJson('/api/v1/articles/'.$article->getSlug().'/views', ['event_id' => (string) \Illuminate\Support\Str::uuid()])
            ->assertOk()->assertJsonPath('data.views', 2);
        $this->assertSame($before, $this->revisions->current());
        $this->assertSame(2, $article->fresh()->views);
    }

    public function test_api_reads_do_not_bump(): void
    {
        $before = $this->revisions->current();
        $this->getJson('/api/v1/articles')->assertOk();
        $this->getJson('/api/v1/clubs')->assertOk();
        $this->assertSame($before, $this->revisions->current());
    }

    public function test_deletion_bumps(): void
    {
        $before = $this->revisions->current();
        $this->data['serc']->delete();
        $this->assertSame($before + 1, $this->revisions->current());
    }
}
