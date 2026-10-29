<?php

namespace App\Services;

use App\Models\Resource;
use App\Support\PublicContent as Content;
use Illuminate\Database\Eloquent\Builder;

class PublicResources
{
    /** Unattached uploads are not a public document directory. */
    public function query(): Builder
    {
        $archiveIds = collect(config('public_site.championships', []))->flatMap(fn ($year) => $year['links'] ?? [])
            ->pluck('url')->filter(fn ($url) => preg_match('#^/resources/view/[a-f0-9-]{36}$#i', $url))
            ->map(fn ($url) => basename($url))->unique()->all();
        return Resource::where(function ($q) use ($archiveIds) {
            $q->whereIn('id', function ($sub) {
                $sub->select('resource')->from('resource_page_section_resources')->join('resource_page_sections', 'resource_page_sections.id', '=', 'resource_page_section_resources.section')->join('resource_pages', 'resource_pages.id', '=', 'resource_page_sections.page');
            })->orWhereIn('id', fn ($sub) => $sub->select('resource_id')->from('serc_resources'))
                ->orWhereIn('id', fn ($sub) => $sub->select('pack_resource')->from('competitions')->whereNotNull('pack_resource'))
                ->orWhereIn('id', fn ($sub) => $sub->select('results_resource')->from('competitions')->whereNotNull('results_resource'))
                ->orWhereIn('id', fn ($sub) => $sub->select('results_link')->from('competitions')->where('results_type', 'RESOURCE'))
                ->orWhereIn('id', $archiveIds);
        });
    }

    public function entry(Resource $resource): array
    {
        return Content::entry($resource, 'resources', $resource->name, $resource->id);
    }
}
