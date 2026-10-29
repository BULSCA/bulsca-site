<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Resource;
use App\Models\Season;
use App\Support\PublicContent as Content;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function entry(Competition $comp): array
    {
        $title = ($comp->hostUni?->name ?? 'BULSCA Competition').' '.$comp->when->format('Y');
        $result = $this->result($comp);
        return array_filter(Content::entry($comp, 'competitions', $title) + ['date' => $comp->when->timezone('Europe/London')->format('Y-m-d'), 'summary' => $comp->short, 'location' => $comp->getInfo?->general_location, 'image_url' => Content::image($comp->hostUni?->image_path), 'results_link' => $result], fn ($v) => $v !== null);
    }

    private function result(Competition $comp): ?array
    {
        $id = $comp->results_resource ?: ($comp->results_type === 'RESOURCE' ? $comp->results_link : null);
        if ($id) return Resource::whereKey($id)->exists() ? Content::link('View results', '/resources/view/'.$id) : null;
        return $comp->results_type === 'LINK' ? Content::link('View results', $comp->results_link) : null;
    }

    public function index(Request $request): array
    {
        $query = Competition::with('hostUni', 'getInfo')->orderByDesc('when')->orderByDesc('id');
        $request->validate(['q' => 'sometimes|nullable|string|max:200']);
        if ($request->filled('q')) $query->whereHas('hostUni', fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'));
        return Content::collection($request, $query, $this->entry(...), search: null);
    }

    public function highlights(Request $request): array
    {
        $today = now('Europe/London')->startOfDay();
        $query = Competition::with('hostUni', 'getInfo')->whereBetween('when', [$today->copy()->subDay()->utc(), $today->copy()->addDays(14)->endOfDay()->utc()])->orderBy('when')->orderBy('id');
        return Content::collection($request, $query, $this->entry(...), search: null);
    }

    public function show(string $slug): array
    {
        $comp = Competition::with('hostUni', 'getInfo')->findOrFail(Content::id($slug));
        $info = $comp->getInfo;
        $sections = [];
        if ($info) {
            foreach (['general_location' => 'Location', 'general_required_kit' => 'Required kit', 'teams_extra' => 'Teams', 'registration_extra' => 'Registration', 'pool_extra' => 'Pool', 'food_options' => 'Food', 'social_theme' => 'Social', 'accom_extra' => 'Accommodation', 'extra_info' => 'Further information'] as $field => $label) {
                if ($info->$field) $sections[] = Content::section($label, $info->$field);
            }
            $details = [];
            foreach (['teams_cost' => 'Team cost', 'teams_limit' => 'Team limit', 'pool_location' => 'Pool', 'pool_length' => 'Pool length', 'pool_lanes' => 'Lanes', 'registration_location' => 'Registration', 'food_cost' => 'Food cost', 'social_location' => 'Social venue', 'social_cost' => 'Social cost', 'accom_location' => 'Accommodation', 'accom_cost' => 'Accommodation cost', 'contact_organiser_name' => 'Organiser', 'contact_organiser_email' => 'Organiser email', 'contact_emergency_name' => 'Emergency contact', 'contact_emergency_email' => 'Emergency email'] as $field => $label) {
                if ($info->$field !== null && $info->$field !== '') $details[] = $label.': '.$info->$field;
            }
            // Preserve the legacy near-event phone visibility window; never expose all info fields.
            if (now()->betweenIncluded($comp->when->copy()->subDay(), $comp->when)) {
                foreach (['contact_organiser_phone', 'contact_emergency_phone'] as $field) if ($info->$field) $details[] = 'Contact phone: '.$info->$field;
            }
            $sections[] = ['heading' => 'Event details', 'paragraphs' => $details];
            if ($info->timetable) $sections[] = ['heading' => 'Timetable', 'paragraphs' => collect($info->timetable)->filter(fn ($time) => $time === null || is_scalar($time))->map(fn ($time, $key) => str_replace(['timetable_', '_'], ['', ' '], (string) $key).': '.($time ?: 'To be confirmed'))->values()];
        }
        $links = [$this->result($comp)];
        if ($comp->pack_resource && Resource::whereKey($comp->pack_resource)->exists()) $links[] = Content::link('Information pack', '/resources/view/'.$comp->pack_resource);
        foreach (['form_entry' => 'Entry form', 'form_judges' => 'Judges form', 'form_helpers' => 'Helpers form'] as $field => $label) $links[] = Content::link($label, $info?->$field);
        return ['data' => $this->entry($comp) + ['sections' => $sections, 'links' => Content::links($links)]];
    }

    public function seasons(Request $request): array
    {
        return Content::collection($request, Season::whereNotNull('from')->whereNotNull('to')->orderByDesc('from')->orderByDesc('id'), fn ($season) => Content::entry($season, 'seasons', $season->name, $season->getDateSlug()));
    }

    public function standings(string $season): array
    {
        if ($season === 'current') $item = Season::current();
        else {
            abort_unless(preg_match('/^\d{4}-\d{2}$/', $season), 404);
            $item = Season::whereYear('from', substr($season, 0, 4))->get()->first(fn ($s) => $s->getDateSlug() === $season);
        }
        abort_unless($item, 404);
        $tables = [];
        foreach (['a' => 'A League', 'b' => 'B League', 'o' => 'Overall'] as $league => $label) {
            if ($league === 'o' && (int) $item->from->format('Y') >= 2026) continue;
            $results = $item->getLeagueResults($league);
            $tables[] = ['caption' => $label, 'columns' => $results['cols'], 'rows' => collect($results['data'])->values()->map(fn ($row, $index) => [$row['team'], $index + 1, (int) $row['points'], ...array_map(fn ($host) => (int) ($row['positionPoints'][$host] ?? 0), $results['comps'])])->all()];
        }
        return ['data' => Content::entry($item, 'seasons', $item->name, $item->getDateSlug()) + ['sections' => [], 'tables' => $tables, 'entries' => $item->competitions()->with('hostUni', 'getInfo')->orderBy('when')->get()->map($this->entry(...))->values()]];
    }

    public function championships(Request $request): array
    {
        $years = array_keys(config('public_site.championships', []));
        rsort($years);
        return Content::items($request, collect($years)->map(fn ($year) => $this->championshipEntry((string) $year)));
    }

    private function championshipEntry(string $year): array
    {
        return ['id' => $year, 'slug' => $year, 'kind' => 'championships', 'title' => 'Championships '.$year];
    }

    public function championship(string $year): array
    {
        $content = config('public_site.championships.'.$year);
        abort_unless($content, 404);
        return ['data' => $this->championshipEntry($year) + $content];
    }
}
