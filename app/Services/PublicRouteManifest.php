<?php

namespace App\Services;

use App\Models\{Article, Casualty\Casualty, Competition, Resource, ResourcePage, Season, SERC\SERC, Tag, University};
use App\Models\Committee\{Committee, CommitteeMember};
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Enumerates the published public pages of the website for prerendering.
 * Reads only; every route is listed once and the list is sorted by URL.
 */
class PublicRouteManifest
{
    /** Fixed informational pages, mirroring the public routes in routes/web.php. */
    private const PAGES = [
        ['/', 'Home'],
        ['/freshers', 'Freshers'],
        ['/competitions', 'Competitions'],
        ['/competitions/championships', 'Championships'],
        ['/competitions/league', 'Current league'],
        ['/competitions/previous-leagues', 'Previous leagues'],
        ['/get-involved', 'Get involved'],
        ['/get-involved/committee/index', 'Current committee'],
        ['/get-involved/previous-committees', 'Previous committees'],
        ['/get-involved/clubs', 'Clubs'],
        ['/resources', 'Resources'],
        ['/resources/forms', 'Forms'],
        ['/resources/sercs', 'SERC scenarios'],
        ['/resources/casualties', 'Casualties'],
        ['/about', 'About'],
        ['/about/records', 'Records'],
        ['/contact', 'Contact'],
        ['/contact-form', 'Contact form'],
        ['/latest', 'Latest news'],
        ['/privacy', 'Privacy policy'],
        ['/terms-of-service', 'Terms of service'],
        ['/cookies', 'Cookies'],
        ['/welfare', 'Welfare'],
        ['/welfare/support-and-reporting', 'Support and reporting'],
        ['/welfare/inclusion-and-accessibility', 'Inclusion and accessibility'],
    ];

    public function __construct(private PublicResources $resources) {}

    /** @return array<int, array{url: string, kind: string, title: string}> */
    public function routes(): array
    {
        return $this->pages()
            ->concat($this->articles())
            ->concat($this->tags())
            ->concat($this->clubs())
            ->concat($this->committees())
            ->concat($this->seasons())
            ->concat($this->championships())
            ->concat($this->competitions())
            ->concat($this->resourcePages())
            ->concat($this->downloads())
            ->concat($this->sercs())
            ->concat($this->casualties())
            ->unique(fn (array $route) => $route['url'])
            ->sortBy(fn (array $route) => $route['url'])
            ->values()
            ->all();
    }

    private function route(string $url, string $kind, string $title): array
    {
        return ['url' => $url, 'kind' => $kind, 'title' => $title];
    }

    private function pages(): Collection
    {
        return collect(self::PAGES)->map(fn (array $page) => $this->route($page[0], 'page', $page[1]));
    }

    private function articles(): Collection
    {
        return Article::orderBy('id')->get()
            ->map(fn (Article $article) => $this->route('/article/'.Str::slug($article->title).'.'.$article->id, 'article', $article->title));
    }

    private function tags(): Collection
    {
        return Tag::whereHas('articles')->orderBy('slug')->get()
            ->map(fn (Tag $tag) => $this->route('/articles/tag/'.$tag->slug, 'tag', $tag->name));
    }

    private function clubs(): Collection
    {
        return University::where('active', true)->orderBy('id')->get()
            ->map(fn (University $club) => $this->route('/get-involved/clubs/'.Str::slug($club->name).'.'.$club->id, 'club', $club->name));
    }

    private function committees(): Collection
    {
        $committees = Committee::whereNotNull('start_date')->whereNotNull('end_date')->with('members')->orderBy('id')->get();
        return $committees
            ->map(fn (Committee $committee) => $this->route('/get-involved/committee/'.$committee->date_slug, 'committee', $committee->name))
            ->concat($committees->flatMap(fn (Committee $committee) => $committee->members
                ->map(fn (CommitteeMember $member) => $this->route('/get-involved/committee/'.$committee->date_slug.'/'.$member->name_slug, 'committee-member', $member->name))));
    }

    private function seasons(): Collection
    {
        return Season::whereNotNull('from')->whereNotNull('to')->orderBy('id')->get()
            ->map(fn (Season $season) => $this->route('/competitions/league/'.$season->getDateSlug(), 'season', $season->name));
    }

    private function championships(): Collection
    {
        return collect(array_keys(config('public_site.championships', [])))
            ->sort()
            ->map(fn (string $year) => $this->route('/competitions/championships/'.$year, 'championship', 'Championships '.$year));
    }

    private function competitions(): Collection
    {
        // Title rule mirrors Api\V1\CompetitionController::entry().
        return Competition::with('hostUni')->orderBy('id')->get()
            ->map(function (Competition $competition) {
                $title = ($competition->hostUni?->name ?? 'BULSCA Competition').' '.$competition->when->format('Y');
                return $this->route('/competitions/'.Str::slug($title).'.'.$competition->id, 'competition', $title);
            });
    }

    private function resourcePages(): Collection
    {
        return ResourcePage::orderBy('id')->get()
            ->map(fn (ResourcePage $page) => $this->route('/resources/'.Str::slug($page->name), 'resource-page', $page->name));
    }

    private function downloads(): Collection
    {
        return $this->resources->query()->orderBy('name')->orderBy('id')->get()
            ->map(fn (Resource $resource) => $this->route('/resources/view/'.$resource->id, 'resource', $resource->name));
    }

    private function sercs(): Collection
    {
        return SERC::orderBy('id')->get()
            ->map(fn (SERC $serc) => $this->route('/resources/sercs/'.Str::slug($serc->name).'.'.$serc->id, 'serc', $serc->name));
    }

    private function casualties(): Collection
    {
        return Casualty::orderBy('id')->get()
            ->map(fn (Casualty $casualty) => $this->route('/resources/casualties/'.Str::slug($casualty->name).'.'.$casualty->id, 'casualty', $casualty->name));
    }
}
