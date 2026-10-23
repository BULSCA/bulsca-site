<?php

namespace App\Http\Resources;

use App\Support\ArticleContent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $content = app(ArticleContent::class);
        return [
            'id' => $this->id,
            'slug' => $this->getSlug(),
            'title' => $this->title,
            'author' => $this->writer?->name,
            'excerpt' => $content->excerpt($this->content),
            'pinned' => (bool) $this->pinned,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'views' => (int) $this->views,
            'thumbs_up' => (int) $this->thumbs_up,
            'thumbs_down' => (int) $this->thumbs_down,
            'tags' => $this->tags->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name, 'slug' => $tag->slug])->values(),
            'content' => $this->when($request->routeIs('api.v1.articles.show'), fn () => $content->sanitize($this->content)),
        ];
    }
}
