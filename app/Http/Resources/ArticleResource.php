<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ArticleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'author' => $this->author,
            'pinned' => $this->pinned,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'views' => $this->views,
            'thumbs_up' => $this->thumbs_up,
            'thumbs_down' => $this->thumbs_down
        ];
    }
}
