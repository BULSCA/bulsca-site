<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/** Explicit public DTOs; never serialize a management model wholesale. */
class PublicContent
{
    public static function id(string $slug): string
    {
        $id = Str::afterLast($slug, '.');
        abort_unless(ctype_digit($id) && (int) $id > 0, 404);
        return $id;
    }

    public static function entry($model, string $kind, string $title, ?string $slug = null): array
    {
        return ['id' => $model->id, 'kind' => $kind, 'slug' => $slug ?? Str::slug($title).'.'.$model->id, 'title' => $title];
    }

    public static function section(string $heading, ?string $content): array
    {
        $html = app(ArticleContent::class)->sanitize($content ?? '');
        return ['heading' => $heading, 'paragraphs' => [], 'html' => $html];
    }

    public static function link(string $label, ?string $url): ?array
    {
        if (! $url || preg_match('/[\x00-\x20\x7f\\\\]/', $url) || str_starts_with($url, '//')) {
            return null;
        }
        if (! str_starts_with($url, '/') && ! preg_match('/^(https?:\/\/|mailto:)/i', $url)) {
            return null;
        }
        return ['label' => $label, 'url' => $url];
    }

    public static function links(array $links): array
    {
        return array_values(array_filter($links));
    }

    public static function image(?string $path): ?string
    {
        if (! $path) return null;
        if (preg_match('/^https?:\/\//i', $path)) return self::link('Image', $path)['url'] ?? null;
        if (str_contains($path, '..') || str_contains($path, '\\')) return null;
        if (str_starts_with($path, '/storage/') || str_starts_with($path, 'public/')) return self::url('/storage/'.ltrim(preg_replace('#^(public/|/?storage/)#', '', $path), '/'));
        return self::url(route('image', ['path' => ltrim($path, '/')], false));
    }

    public static function url(string $path): string
    {
        $origin = config('public_site.api_url');
        return $origin ? rtrim($origin, '/').'/'.ltrim($path, '/') : url($path);
    }

    public static function collection(Request $request, Builder $query, callable $map, ?string $search = 'name', int $size = 12): array
    {
        $request->validate(['page' => 'sometimes|integer|min:1|max:100000', 'q' => 'sometimes|nullable|string|max:200', 'tag' => 'sometimes|nullable|string|max:100']);
        if ($search !== null && $request->filled('q')) $query->where($search, 'like', '%'.$request->string('q').'%');
        $page = $query->paginate($size);
        return ['data' => $page->getCollection()->map($map)->values(), 'meta' => ['current_page' => $page->currentPage(), 'last_page' => $page->lastPage(), 'total' => $page->total()]];
    }

    public static function items(Request $request, Collection $items): array
    {
        $request->validate(['page' => 'sometimes|integer|min:1|max:100000']);
        $page = (int) $request->input('page', 1);
        return ['data' => $items->slice(($page - 1) * 12, 12)->values(), 'meta' => ['current_page' => $page, 'last_page' => max(1, (int) ceil($items->count() / 12)), 'total' => $items->count()]];
    }
}
