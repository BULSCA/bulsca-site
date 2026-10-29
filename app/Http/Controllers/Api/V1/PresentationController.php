<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\PublicContent as Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PresentationController extends Controller
{
    public function presentation(): array
    {
        $config = config('public_site.presentation');
        $config['banner_overrides'] = (object) $config['banner_overrides'];
        return ['data' => $config];
    }

    public function notice(): array
    {
        $banner = \App\Models\GlobalNotification::getBanner();
        return ['data' => $banner ? Content::section($banner->title ?? '', $banner->content) : null];
    }

    public function social(Request $request): array
    {
        $cache = Cache::store(config('public_site.cache_store'));
        $cached = $cache->get('public-social');
        if (is_array($cached) && $cached['refresh_after'] > time()) return Content::items($request, collect($cached['items'])) + (! empty($cached['stale']) ? ['stale' => true] : []);
        try {
            $token = app(\App\Services\MetaTokenStore::class)->get();
            if (! config('services.meta.user_id') || ! $token) return Content::items($request, collect());
            $response = Http::connectTimeout(2)->timeout(5)->get('https://graph.facebook.com/v24.0/'.config('services.meta.user_id').'/media', [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp', 'limit' => 12, 'access_token' => $token,
            ])->throw();
            $posts = $response->json('data');
            if (! is_array($posts)) throw new \RuntimeException('Invalid social response');
            $items = collect($posts)->filter(fn ($post) => is_array($post) && isset($post['id']) && (is_string($post['id']) || is_int($post['id'])))->map(fn ($post) => array_filter([
                'id' => (string) $post['id'], 'slug' => (string) $post['id'], 'kind' => 'social', 'title' => 'BULSCA community update',
                'summary' => is_string($post['caption'] ?? null) ? mb_substr($post['caption'], 0, 1000) : '',
                'image_url' => Content::link('Image', is_string($post['thumbnail_url'] ?? null) ? $post['thumbnail_url'] : (is_string($post['media_url'] ?? null) ? $post['media_url'] : null))['url'] ?? null,
                'links' => Content::links([Content::link('View update', is_string($post['permalink'] ?? null) ? $post['permalink'] : null)]),
            ], fn ($value) => $value !== null))->values()->all();
            $cache->put('public-social', ['refresh_after' => time() + 3600, 'expires_at' => time() + 86400, 'items' => $items], 86400);
            return Content::items($request, collect($items));
        } catch (\Throwable $error) {
            if (is_array($cached)) {
                try {
                    \Illuminate\Support\Facades\Log::channel('diagnostics')->warning('social_provider_unavailable', ['request_id' => $request->attributes->get('request_id'), 'route_template' => 'api/v1/social/posts']);
                } catch (\Throwable) { /* Reporting remains best effort. */ }
                $cached['refresh_after'] = time() + 60;
                $cached['stale'] = true;
                $cache->put('public-social', $cached, max(1, ($cached['expires_at'] ?? time() + 60) - time()));
                return Content::items($request, collect($cached['items'])) + ['stale' => true];
            }
            // The common API handler logs only safe context, never provider URLs/tokens.
            throw new \RuntimeException('Social feed unavailable');
        }
    }
}
