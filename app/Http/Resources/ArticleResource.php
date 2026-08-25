<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ArticleResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'author' => $this->author,
            'pinned' => $this->pinned,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'views' => $this->views,
            'thumbs_up' => $this->thumbs_up,
            'thumbs_down' => $this->thumbs_down
        ];

        // Include content only when viewing a single article
        if ($request->route()->getName() === 'api.articles.show') {
            $data['content'] = $this->content;
        } else {
            $data['excerpt'] = $this->getExcerpt();
        }

        return $data;
    }
}