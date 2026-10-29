<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ResourcePage;
use App\Services\PublicResources;
use App\Support\PublicContent as Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function __construct(private PublicResources $resources) {}

    public function pages(Request $request): array
    {
        return Content::collection($request, ResourcePage::orderBy('ordering')->orderBy('id'), fn ($page) => Content::entry($page, 'resource-pages', $page->name, Str::slug($page->name)));
    }

    public function page(string $slug): array
    {
        $page = ResourcePage::get()->first(fn ($page) => Str::slug($page->name) === $slug) ?? abort(404);
        $sections = $page->getSections()->with('getRPSR.getResource')->orderBy('ordering')->orderBy('id')->get();
        return ['data' => Content::entry($page, 'resource-pages', $page->name, Str::slug($page->name)) + [
            'sections' => $sections->map(fn ($section) => ['heading' => $section->name, 'paragraphs' => [], 'bullets' => $section->getRPSR->pluck('short')->filter()->values()])->values(),
            'entries' => $sections->flatMap(fn ($section) => $section->getRPSR->map(fn ($item) => $item->getResource ? $this->resources->entry($item->getResource) + ['summary' => $item->short ?? ''] : null))->filter()->values(),
        ]];
    }

    public function index(Request $request): array
    {
        $query = $this->resources->query()->orderBy('name')->orderBy('id');
        // Search extracted document text as well as names without leaking private uploads.
        $request->validate(['q' => 'sometimes|nullable|string|max:200']);
        if ($request->filled('q')) {
            $term = '%'.$request->string('q').'%';
            $query->where(fn ($q) => $q->where('name', 'like', $term)->orWhereIn('id', fn ($sub) => $sub->select('resource')->from('resource_page_section_resources')->where('content', 'like', $term)->orWhere('name', 'like', $term)));
        }
        return Content::collection($request, $query, $this->resources->entry(...), search: null);
    }

    public function show(string $id): array
    {
        $resource = $this->resources->query()->findOrFail($id);
        return ['data' => $this->resources->entry($resource) + ['sections' => [], 'downloadable' => true]];
    }

    public function access(string $id): array
    {
        $resource = $this->resources->query()->findOrFail($id);
        abort_unless(Storage::exists($resource->location), 404);
        return ['data' => ['url' => route('api.v1.resources.file', ['id' => $resource->id]), 'filename' => $resource->name, 'expires_at' => null]];
    }

    public function file(string $id)
    {
        $resource = $this->resources->query()->findOrFail($id);
        abort_unless(Storage::exists($resource->location), 404);
        $extension = pathinfo($resource->location, PATHINFO_EXTENSION);
        $name = Str::ascii($resource->name);
        $name = preg_replace('/[\x00-\x1f\x7f\\\\\/]/', '-', $name) ?: 'document';
        return Storage::download($resource->location, $name.($extension ? '.'.$extension : ''), ['X-Content-Type-Options' => 'nosniff']);
    }
}
