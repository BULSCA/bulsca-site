<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Committee\Committee;
use App\Models\Committee\CommitteeMember;
use App\Models\University;
use App\Support\PublicContent as Content;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function clubs(Request $request): array
    {
        return Content::collection($request, University::where('active', true)->orderBy('name')->orderBy('id'), $this->clubEntry(...));
    }

    public function club(string $slug): array
    {
        $club = University::where('active', true)->findOrFail(Content::id($slug));
        return ['data' => $this->clubEntry($club) + ['sections' => [Content::section('About the club', $club->getPage?->content)]]];
    }

    private function clubEntry(University $club): array
    {
        return array_filter(Content::entry($club, 'clubs', $club->name) + [
            'location' => $club->location, 'image_url' => Content::image($club->image_path),
            'links' => Content::links([Content::link('Website', $this->website($club->website)), Content::link('Facebook', $this->social('facebook.com', $club->facebook)), Content::link('Instagram', $this->social('instagram.com', $club->instagram))]),
        ], fn ($value) => $value !== null);
    }

    private function website(?string $value): ?string
    {
        if (! $value) return null;
        return preg_match('/^[a-z][a-z0-9+.-]*:/i', $value) ? $value : 'https://'.$value;
    }

    private function social(string $host, ?string $value): ?string
    {
        if (! $value) return null;
        return preg_match('/^[a-z][a-z0-9+.-]*:/i', $value) ? $value : 'https://'.$host.'/'.ltrim($value, '@');
    }

    public function committees(Request $request): array
    {
        return Content::collection($request, Committee::whereNotNull('start_date')->whereNotNull('end_date')->orderByDesc('start_date')->orderByDesc('id'), $this->committeeEntry(...));
    }

    private function findCommittee(string $season): Committee
    {
        if ($season === 'current') {
            $committee = Committee::current();
            abort_unless($committee && $committee->start_date && $committee->end_date, 404);
            return $committee;
        }
        abort_unless(preg_match('/^\d{4}-\d{2}$/', $season), 404);
        return Committee::whereYear('start_date', substr($season, 0, 4))->whereNotNull('end_date')->get()->first(fn ($item) => $item->date_slug === $season) ?? abort(404);
    }

    private function committeeEntry(Committee $committee): array
    {
        return Content::entry($committee, 'committees', $committee->name, $committee->date_slug);
    }

    private function memberEntry(CommitteeMember $member): array
    {
        return array_filter(Content::entry($member, 'members', $member->name) + [
            'parent' => $member->committee->date_slug, 'image_url' => Content::image($member->image_path),
            'role_label' => $member->role?->label, 'role_order' => max(0, $member->role?->order ?? 0),
        ], fn ($value) => $value !== null);
    }

    public function committee(string $season): array
    {
        $committee = $this->findCommittee($season);
        $members = $committee->members()->with('role', 'committee')->get()->sortBy(fn ($m) => [$m->role?->order ?? PHP_INT_MAX, $m->id]);
        return ['data' => $this->committeeEntry($committee) + ['sections' => [], 'entries' => $members->map($this->memberEntry(...))->values()]];
    }

    public function member(string $season, string $slug): array
    {
        $committee = $this->findCommittee($season);
        $members = $committee->members()->with('role', 'committee', 'affiliatedUniversity');
        $member = preg_match('/(?:^|\.)\d+$/', $slug)
            ? $members->findOrFail(Content::id($slug))
            : ($members->get()->first(fn ($item) => $item->name_slug === $slug) ?? abort(404));
        $sections = [];
        if ($member->content) $sections[] = Content::section('Biography', $member->content);
        if ($member->affiliatedUniversity) $sections[] = ['heading' => 'University', 'paragraphs' => [$member->affiliatedUniversity->name]];
        return ['data' => $this->memberEntry($member) + [
            'sections' => $sections,
            'role_sections' => $member->role?->content ? [Content::section('About the role', $member->role->content)] : [],
        ]];
    }
}
