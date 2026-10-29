<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Support\PublicContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleInteractionController extends Controller
{
    public function view(Request $request, string $slug): array
    {
        return $this->record($request, $slug, 'views');
    }

    public function rate(Request $request, string $slug): array
    {
        $request->validate(['type' => 'required|in:up,down']);
        return $this->record($request, $slug, $request->input('type') === 'up' ? 'thumbs_up' : 'thumbs_down');
    }

    private function record(Request $request, string $slug, string $counter): array
    {
        $data = $request->validate(['event_id' => 'required|uuid']);
        $article = Article::findOrFail(PublicContent::id($slug));
        $cache = Cache::store(config('public_site.cache_store'));
        // One event can never be replayed as a different vote. Counters update atomically.
        $key = 'article-event:'.hash('sha256', $article->id.':'.$data['event_id'].':'.$request->ip());
        $accepted = $cache->add($key, true, 86400);
        abort_if(! $accepted && ! $cache->has($key), 503);
        if ($accepted) {
            try {
                DB::table('articles')->where('id', $article->id)->increment($counter);
            } catch (\Throwable $error) {
                $cache->forget($key);
                throw $error;
            }
        }
        $article->refresh();
        return ['data' => ['views' => (int) $article->views, 'thumbs_up' => (int) $article->thumbs_up, 'thumbs_down' => (int) $article->thumbs_down]];
    }
}
