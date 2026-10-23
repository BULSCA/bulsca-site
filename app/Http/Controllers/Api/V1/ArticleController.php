<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'page' => ['sometimes', 'integer', 'min:1'],
            'tag' => ['sometimes', 'string', 'max:255'],
        ]);
        $query = Article::query()->with(['tags', 'writer'])->orderByDesc('created_at')->orderByDesc('id');
        if (isset($validated['tag'])) {
            $tag = Tag::where('slug', $validated['tag'])->firstOrFail();
            $query->whereHas('tags', fn ($tags) => $tags->where('tags.id', $tag->id));
        }
        $pinned = (clone $query)->where('pinned', true)->get();
        $articles = (clone $query)->where('pinned', false)->paginate(8)->withQueryString();

        return response()->json([
            'data' => [
                'pinned' => ArticleResource::collection($pinned)->resolve($request),
                'articles' => ArticleResource::collection($articles->getCollection())->resolve($request),
            ],
            'meta' => ['current_page' => $articles->currentPage(), 'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(), 'total' => $articles->total()],
            'links' => ['prev' => $articles->previousPageUrl(), 'next' => $articles->nextPageUrl()],
        ]);
    }

    public function show(string $slug)
    {
        abort_unless(preg_match('/(?:^|\.)([1-9]\d*)$/', $slug, $matches), 404);
        return new ArticleResource(Article::with(['tags', 'writer'])->findOrFail($matches[1]));
    }
}
