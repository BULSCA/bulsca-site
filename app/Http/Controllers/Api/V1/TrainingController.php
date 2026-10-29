<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Casualty\Casualty;
use App\Models\SERC\SERC;
use App\Services\PublicResources;
use App\Support\PublicContent as Content;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    private function sercEntry(SERC $serc): array
    {
        return Content::entry($serc, 'sercs', $serc->name) + ['summary' => app(\App\Support\ArticleContent::class)->excerpt($serc->description ?? ''), 'date' => $serc->when->format('Y-m-d'), 'location' => $serc->where, 'tags' => $serc->tags->pluck('name')->values()];
    }

    private function casualtyEntry(Casualty $casualty): array
    {
        return array_filter(Content::entry($casualty, 'casualties', $casualty->name) + ['summary' => app(\App\Support\ArticleContent::class)->excerpt($casualty->description ?? ''), 'tags' => $casualty->tags->pluck('name')->values(), 'image_url' => $casualty->getImages->first() ? route('image', ['path' => $casualty->getImages->first()->path]) : null], fn ($v) => $v !== null);
    }

    private function tag(Request $request, $query): void
    {
        $request->validate(['tags' => ['sometimes', 'nullable', 'string', 'max:200', 'regex:/^\d+(,\d+){0,29}$/']]);
        if ($request->filled('tag')) $query->whereHas('tags', fn ($q) => $q->where('name', $request->string('tag')));
        if ($request->filled('tags')) $query->whereHas('tags', fn ($q) => $q->whereIn('serc_tags.id', explode(',', $request->input('tags'))));
    }

    public function sercs(Request $request): array
    {
        $request->validate(['year' => 'sometimes|nullable|integer|min:1900|max:2200', 'location' => 'sometimes|nullable|string|max:100', 'author' => 'sometimes|nullable|string|max:200', 'cas_min' => 'sometimes|nullable|integer|min:0|max:1000', 'cas_max' => 'sometimes|nullable|integer|min:0|max:1000'.($request->filled('cas_min') ? '|gte:cas_min' : '')]);
        $query = SERC::with('tags')->orderByDesc('when')->orderByDesc('id');
        $this->tag($request, $query);
        if ($request->filled('year')) $query->whereYear('when', $request->integer('year'));
        if ($request->filled('location')) $query->where('where', $request->string('location'));
        if ($request->filled('author')) $query->where('author', 'like', '%'.$request->string('author').'%');
        if ($request->filled('cas_min')) $query->where('casualties', '>=', $request->integer('cas_min'));
        if ($request->filled('cas_max')) $query->where('casualties', '<=', $request->integer('cas_max'));
        return Content::collection($request, $query, $this->sercEntry(...)) + ['filters' => [
            'tags' => \App\Models\SERC\SERCTag::orderBy('name')->pluck('name')->all(),
            'years' => SERC::selectRaw('YEAR(`when`) as year')->distinct()->orderByDesc('year')->pluck('year')->map(fn ($year) => (int) $year)->all(),
            'locations' => SERC::distinct()->orderBy('where')->pluck('where')->all(),
        ]];
    }

    public function serc(string $slug, PublicResources $resources): array
    {
        $serc = SERC::with('tags', 'getResources')->findOrFail(Content::id($slug));
        return ['data' => $this->sercEntry($serc) + ['sections' => [Content::section('Scenario', $serc->description), ['heading' => 'Scenario information', 'paragraphs' => array_values(array_filter([$serc->author ? 'Author: '.$serc->author : null, $serc->casualties !== null ? 'Casualties: '.$serc->casualties : null]))]], 'entries' => $serc->getResources->map($resources->entry(...))->values()]];
    }

    public function casualties(Request $request): array
    {
        $request->validate(['group' => 'sometimes|nullable|integer|min:1']);
        $query = Casualty::with('tags', 'getImages')->orderBy('name')->orderBy('id');
        $this->tag($request, $query);
        if ($request->filled('group')) $query->where('group', $request->integer('group'));
        return Content::collection($request, $query, $this->casualtyEntry(...)) + ['filters' => [
            'tags' => \App\Models\SERC\SERCTag::orderBy('name')->pluck('name')->all(),
            'groups' => \App\Models\Casualty\CasualtyGroup::orderBy('name')->get(['id', 'name'])->toArray(),
        ]];
    }

    public function casualty(string $slug): array
    {
        $casualty = Casualty::with('tags', 'getImages', 'getCasualtyGroup')->findOrFail(Content::id($slug));
        $related = SERC::with('tags')->whereHas('tags', fn ($q) => $q->whereIn('serc_tags.id', $casualty->tags->pluck('id')))->orderByDesc('when')->get();
        return ['data' => $this->casualtyEntry($casualty) + ['sections' => [Content::section('Briefing', $casualty->description), ['heading' => 'Reference', 'paragraphs' => array_values(array_filter([$casualty->manual_reference, $casualty->getCasualtyGroup?->name]))]], 'images' => $casualty->getImages->map(fn ($image) => Content::link($casualty->name, route('image', ['path' => $image->path])))->filter()->values(), 'entries' => $related->map($this->sercEntry(...))->values()]];
    }
}
