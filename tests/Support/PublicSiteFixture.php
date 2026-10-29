<?php

namespace Tests\Support;

use App\Models\{Article, Casualty\Casualty, Casualty\CasualtyGroup, ClubPage, Committee\Committee, Committee\CommitteeMember, Committee\CommitteeRole, Competition, CompetitionInfo, LeaguePlace, Resource, ResourcePage, ResourcePageSection, ResourcePageSectionResource, Season, SERC\SERC, SERC\SERCTag, University};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/** Deterministic data shared by API tests and the real local-browser integration suite. */
class PublicSiteFixture
{
    public static function create(): array
    {
        return Model::unguarded(function () {
            $club = University::create(['name' => 'Test University', 'active' => true, 'location' => 'Test City', 'website' => 'https://example.test/club']);
            $inactive = University::create(['name' => 'Inactive University', 'active' => false]);
            ClubPage::create(['uni' => $club->id, 'content' => '<p>Weekly lifesaving training.</p><script>privateScript()</script>']);
            $season = Season::create(['name' => 'League 2026-27', 'from' => '2026-09-01', 'to' => '2027-08-31']);
            $pastSeason = Season::create(['name' => 'League 2025-26', 'from' => '2025-09-01', 'to' => '2026-08-31']);
            $resource = Resource::create(['name' => 'Test entry pack', 'location' => 'integration/test-pack.txt']);
            Storage::put($resource->location, 'BULSCA isolated integration document');
            $orphan = Resource::create(['name' => 'Unpublished upload', 'location' => 'integration/private.txt']);
            $page = ResourcePage::create(['name' => 'Competition documents', 'ordering' => 1]);
            $section = ResourcePageSection::create(['name' => 'Entry packs', 'page' => $page->id, 'ordering' => 1]);
            ResourcePageSectionResource::create(['section' => $section->id, 'resource' => $resource->id, 'name' => $resource->name, 'short' => 'Published entry information', 'content' => 'Searchable safety guidance', 'ordering' => 1]);
            $comp = Competition::create(['host' => $club->id, 'season' => $season->id, 'when' => '2026-11-04 12:00:00', 'status' => 'ready', 'short' => 'University competition', 'pack_resource' => $resource->id, 'results_type' => 'LINK', 'results_link' => 'https://example.test/results']);
            $info = CompetitionInfo::create(['competition' => $comp->id, 'general_location' => 'Test Pool', 'teams_limit' => 12, 'form_entry' => 'https://example.test/entry', 'contact_organiser_name' => 'Organiser', 'contact_organiser_email' => 'organiser@example.test', 'contact_organiser_phone' => 'PRIVATE-PHONE', 'contact_emergency_phone' => 'PRIVATE-EMERGENCY']);
            LeaguePlace::create(['uni' => $club->id, 'comp' => $comp->id, 'league' => 'a', 'pos' => 1]);
            LeaguePlace::create(['uni' => $club->id, 'comp' => $comp->id, 'league' => 'b', 'pos' => 2]);
            $committee = Committee::create(['name' => 'Committee 2026-27', 'start_date' => '2026-09-01', 'end_date' => '2027-08-31']);
            $pastCommittee = Committee::create(['name' => 'Committee 2025-26', 'start_date' => '2025-09-01', 'end_date' => '2026-08-31']);
            $role = CommitteeRole::create(['label' => 'Chair', 'order' => 1, 'content' => '<p>Coordinates the association.</p>']);
            $committee->roles()->attach($role);
            $member = CommitteeMember::create(['committee_id' => $committee->id, 'role_id' => $role->id, 'affiliated_uni_id' => $club->id, 'name' => 'Test Volunteer', 'content' => '<p>Volunteer biography.</p><script>secret()</script>']);
            $tag = SERCTag::create(['name' => 'Pool']);
            $serc = SERC::create(['name' => 'Pool practice', 'description' => 'A team rescue scenario', 'when' => '2026-10-01', 'where' => 'Pool', 'casualties' => 2, 'author' => 'Test Author']);
            $serc->tags()->attach($tag);
            $serc->getResources()->attach($resource);
            $group = CasualtyGroup::create(['name' => 'First aid']);
            $casualty = Casualty::create(['name' => 'Test casualty', 'group' => $group->id, 'description' => 'Casualty briefing', 'manual_reference' => 'Test reference']);
            $casualty->tags()->attach($tag);
            $article = Article::factory()->create(['title' => 'Test public news', 'content' => '<p>Published news.</p>', 'views' => 0]);
            return compact('club', 'inactive', 'season', 'pastSeason', 'resource', 'orphan', 'page', 'comp', 'info', 'committee', 'pastCommittee', 'member', 'serc', 'casualty', 'article');
        });
    }
}
