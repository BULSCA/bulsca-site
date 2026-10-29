<?php

namespace Tests\Feature\Api;

use App\Models\{CompetitionInfo, LeaguePlace, University};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Cache, DB, Storage};
use Tests\Support\PublicSiteFixture;
use Tests\TestCase;

class PublicBrowsingTest extends TestCase
{
    use RefreshDatabase;

    private array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(now()->setDate(2026, 10, 28)->startOfDay());
        Storage::fake('local');
        config(['filesystems.default' => 'local', 'public_site.cache_store' => 'array']);
        $this->data = PublicSiteFixture::create();
    }

    public function test_clubs_search_pagination_and_unpublished_clubs(): void
    {
        $this->getJson('/api/v1/clubs')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.title', 'Test University')->assertJsonMissing(['title' => 'Inactive University']);
        $this->getJson('/api/v1/clubs?q=absent')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/clubs?page=2')->assertOk()->assertJsonPath('meta.total', 1)->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/clubs?page=0')->assertUnprocessable();
        $this->getJson('/api/v1/clubs/old-title.'.$this->data['club']->id)->assertOk()->assertJsonPath('data.sections.0.html', '<p>Weekly lifesaving training.</p>');
        $this->getJson('/api/v1/clubs/old.'.$this->data['inactive']->id)->assertNotFound();
        $this->getJson('/api/v1/clubs/bad')->assertNotFound();
    }

    public function test_committee_archives_member_scope_roles_and_sanitized_biography(): void
    {
        $this->getJson('/api/v1/committees')->assertOk()->assertJsonCount(2, 'data');
        $this->getJson('/api/v1/committees/current')->assertOk()->assertJsonPath('data.slug', '2026-27')->assertJsonPath('data.entries.0.role_label', 'Chair')->assertJsonPath('data.entries.0.parent', '2026-27');
        $member = $this->data['member'];
        $this->getJson('/api/v1/committees/2026-27/members/old.'.$member->id)->assertOk()->assertJsonPath('data.sections.0.html', '<p>Volunteer biography.</p>')->assertJsonPath('data.role_sections.0.html', '<p>Coordinates the association.</p>');
        $this->getJson('/api/v1/committees/2025-26/members/old.'.$member->id)->assertNotFound();
        $this->getJson('/api/v1/committees/2026-27/members/test-volunteer')->assertOk()->assertJsonPath('data.title', 'Test Volunteer');
        $this->getJson('/api/v1/committees/2026-99')->assertNotFound();
    }

    public function test_competition_reads_do_not_write_and_hide_phones_outside_window(): void
    {
        $id = $this->data['comp']->id;
        $before = DB::table('competition_info')->get()->toJson();
        $this->getJson('/api/v1/competitions/'.$id)->assertOk()->assertJsonPath('data.location', 'Test Pool')->assertJsonPath('data.results_link.url', 'https://example.test/results')->assertDontSee('PRIVATE-PHONE')->assertDontSee('PRIVATE-EMERGENCY');
        $this->assertSame($before, DB::table('competition_info')->get()->toJson());
        CompetitionInfo::where('competition', $id)->delete();
        $this->getJson('/api/v1/competitions/'.$id)->assertOk();
        $this->assertDatabaseCount('competition_info', 0);
        $this->getJson('/api/v1/homepage/highlights')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/competitions?q=absent')->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_minimal_member_profiles_keep_biography_and_role_fallbacks_available(): void
    {
        $this->data['member']->update(['content' => null, 'affiliated_uni_id' => null]);
        $this->data['member']->role->update(['content' => null]);
        $this->getJson('/api/v1/committees/2026-27/members/test-volunteer')->assertOk()->assertJsonCount(0, 'data.sections')->assertJsonCount(0, 'data.role_sections');
    }

    public function test_resources_linked_from_historical_championships_remain_public(): void
    {
        $id = 'f646b5b5-4e3a-41ad-975e-9d92047a3cf6';
        \App\Models\Resource::forceCreate(['id' => $id, 'name' => 'Archived championship pack', 'location' => 'integration/archive.txt']);
        Storage::put('integration/archive.txt', 'Archived pack');
        $this->getJson('/api/v1/resources/'.$id)->assertOk()->assertJsonPath('data.title', 'Archived championship pack');
        $this->getJson('/api/v1/resources/'.$id.'/access')->assertOk();
    }

    public function test_near_event_phone_window_and_unsafe_result_links(): void
    {
        $this->travelTo($this->data['comp']->when->copy()->subHours(12));
        $this->getJson('/api/v1/competitions/'.$this->data['comp']->id)->assertOk()->assertSee('PRIVATE-PHONE');
        $this->data['comp']->update(['results_link' => 'javascript:alert(1)']);
        $this->getJson('/api/v1/competitions/'.$this->data['comp']->id)->assertOk()->assertJsonMissingPath('data.results_link');
    }

    public function test_homepage_date_boundaries_follow_london_days_during_british_summer_time(): void
    {
        $this->travelTo(\Carbon\Carbon::parse('2026-07-01 12:00:00 UTC'));
        $included = $this->data['comp']->replicate();
        $included->when = '2026-06-29 23:30:00'; // June 30 in London: inside the yesterday-to-14-days window.
        $included->save();
        $excluded = $this->data['comp']->replicate();
        $excluded->when = '2026-07-15 23:30:00'; // July 16 in London: outside the window.
        $excluded->save();
        $this->getJson('/api/v1/homepage/highlights')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $included->id)->assertJsonPath('data.0.date', '2026-06-30');
    }

    public function test_standings_preserve_existing_points_and_all_published_leagues(): void
    {
        $response = $this->getJson('/api/v1/seasons/2026-27/standings')->assertOk()->assertJsonCount(2, 'data.tables')->assertJsonPath('data.tables.0.rows.0.2', 10)->assertJsonPath('data.tables.1.rows.0.2', 9);
        $this->assertSame(['Team', 'Position', 'Points', 'Test University'], $response->json('data.tables.0.columns'));
        $this->getJson('/api/v1/seasons/current/standings')->assertOk()->assertJsonPath('data.slug', '2026-27');
        $this->getJson('/api/v1/seasons/2025-26/standings')->assertOk()->assertJsonCount(3, 'data.tables');
        $this->getJson('/api/v1/seasons/2000-01/standings')->assertNotFound();
    }

    public function test_archived_championships_have_real_content_and_unknown_years_are_missing(): void
    {
        $this->getJson('/api/v1/championships')->assertOk()->assertJsonCount(4, 'data');
        foreach ([2023, 2024, 2025, 2026] as $year) $this->getJson('/api/v1/championships/'.$year)->assertOk()->assertJsonPath('data.title', 'Championships '.$year)->assertJsonStructure(['data' => ['sections', 'links']]);
        $this->getJson('/api/v1/championships/2026')->assertOk()->assertSee('Liverpool Aquatics Centre')->assertSee('7th-8th March 2026')->assertSee('27 Feb');
        $this->getJson('/api/v1/championships/2024')->assertOk()->assertSee('Alan Higgs Centre')->assertSee('2nd-3rd March 2024');
        $this->getJson('/api/v1/championships/1990')->assertNotFound();
    }

    public function test_resources_are_published_searchable_and_downloadable_without_storage_paths(): void
    {
        $id = $this->data['resource']->id;
        $this->getJson('/api/v1/resource-pages')->assertOk()->assertJsonPath('data.0.slug', 'competition-documents');
        $this->getJson('/api/v1/resource-pages/competition-documents')->assertOk()->assertJsonPath('data.entries.0.id', $id);
        $this->getJson('/api/v1/resources?q=safety')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/resources?q=absent')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/resources/'.$id)->assertOk()->assertJsonPath('data.downloadable', true)->assertDontSee('integration/test-pack.txt');
        $url = $this->getJson('/api/v1/resources/'.$id.'/access')->assertOk()->json('data.url');
        $this->get($url)->assertOk()->assertDownload('Test entry pack.txt');
        $this->getJson('/api/v1/resources/'.$this->data['orphan']->id)->assertNotFound();
        Storage::delete($this->data['resource']->location);
        $this->getJson('/api/v1/resources/'.$id.'/access')->assertNotFound();
        $this->getJson('/api/v1/resources/'.$id.'/file')->assertNotFound();
        $this->get('/resources/view/missing')->assertNotFound();
    }

    public function test_serc_and_casualty_lists_details_tags_and_links_are_read_only(): void
    {
        $this->getJson('/api/v1/sercs?tag=Pool')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/sercs?tag=unknown')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/sercs?tags='.$this->data['serc']->tags()->first()->id)->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/sercs?tags=999999')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/sercs?tags=bad')->assertUnprocessable();
        $this->getJson('/api/v1/sercs/old.'.$this->data['serc']->id)->assertOk()->assertJsonPath('data.entries.0.id', $this->data['resource']->id);
        $this->assertSame(0, (int) $this->data['serc']->fresh()->views);
        $this->getJson('/api/v1/casualties?q=Test&tag=Pool')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/casualties/old.'.$this->data['casualty']->id)->assertOk()->assertJsonPath('data.entries.0.kind', 'sercs');
        $this->getJson('/api/v1/sercs/missing')->assertNotFound();
    }

    public function test_training_advanced_filters_validate_and_preserve_legacy_search_capabilities(): void
    {
        $this->getJson('/api/v1/sercs?year=2026&location=Pool&author=Test&cas_min=1&cas_max=3')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('filters.years.0', 2026);
        $this->getJson('/api/v1/sercs?cas_min=3')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/sercs?cas_max=3')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/sercs?cas_min=4&cas_max=2')->assertUnprocessable();
        $this->getJson('/api/v1/sercs?year=invalid')->assertUnprocessable();
        $this->getJson('/api/v1/casualties?group=999999')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/casualties')->assertOk()->assertJsonPath('filters.groups.0.name', 'First aid');
    }

    public function test_empty_directories_and_missing_current_entities_are_controlled(): void
    {
        foreach (['competitions', 'seasons', 'universities', 'committees'] as $table) DB::table($table)->delete();
        foreach (['clubs', 'committees', 'seasons', 'competitions', 'homepage/highlights'] as $path) $this->getJson('/api/v1/'.$path)->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/committees/current')->assertNotFound();
        $this->getJson('/api/v1/seasons/current/standings')->assertNotFound();
    }
}
