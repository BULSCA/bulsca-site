<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MetaContentService
{
    protected $accessToken;
    protected $userId;
    //protected $baseUrl = 'https://graph.instagram.com';  // Old Instagram Graph API base URL for user authenticated requests
    protected $baseUrl = 'https://graph.facebook.com/v24.0';

    public function __construct()
    {
        $this->accessToken = config('services.meta.access_token');
        $this->userId = config('services.meta.user_id');
    }

    /**
     * Get the latest posts from Meta
     * 
     * @param int $limit Number of posts to retrieve
     * @return array
     */
    public function getLatestPosts($limit = 10)
    {
        // Cache for 1 hour to avoid hitting rate limits
        $cacheKey = "meta_posts_{$limit}";
        
        return Cache::remember($cacheKey, 3600, function () use ($limit) {
            try {
                // Get media IDs
                $response = Http::get("{$this->baseUrl}/{$this->userId}/media", [
                    'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                    'limit' => $limit,
                    'access_token' => $this->accessToken,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Process and return posts
                    return collect($data['data'] ?? [])->map(function ($post) {
                        return [
                            'id' => $post['id'],
                            'caption' => $post['caption'] ?? '',
                            'type' => $post['media_type'],
                            'image_url' => $this->getMediaUrl($post),
                            'permalink' => $post['permalink'],
                            'timestamp' => $post['timestamp'],
                        ];
                    })->toArray();
                }

                Log::error('Meta API error', ['response' => $response->json()]);
                return [];

            } catch (\Exception $e) {
                Log::error('Meta fetch error', ['error' => $e->getMessage()]);
                return [];
            }
        });
    }

    /**
     * Get the appropriate media URL based on media type
     */
    protected function getMediaUrl($post)
    {
        // For videos, use thumbnail_url if available, otherwise media_url
        if ($post['media_type'] === 'VIDEO' && isset($post['thumbnail_url'])) {
            return $post['thumbnail_url'];
        }
        
        return $post['media_url'] ?? null;
    }

    /**
     * Clear the Meta posts cache
     */
    public function clearCache()
    {
        Cache::forget("meta_posts_10");
        Cache::forget("meta_posts_20");
        Cache::forget("meta_posts_5");
        // Clear oEmbed cache
        Cache::flush();
    }

    /**
     * Get a long-lived access token (lasts 60 days)
     * Call this once to exchange your short-lived token for a long-lived one
     */
    public function getLongLivedToken($shortLivedToken)
    {
        $response = Http::get('https://graph.instagram.com/access_token', [
            'grant_type' => 'ig_exchange_token',
            'client_secret' => config('services.meta.app_secret'),
            'access_token' => $shortLivedToken,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'access_token' => $data['access_token'],
                'expires_in' => $data['expires_in'], // Usually 5184000 (60 days)
            ];
        }

        return null;
    }

    /**
     * Refresh a long-lived token (before it expires)
     */
    public function refreshToken($currentToken = null)
    {
        $token = $currentToken ?? $this->accessToken;
        
        $response = Http::get('https://graph.instagram.com/refresh_access_token', [
            'grant_type' => 'ig_refresh_token',
            'access_token' => $token,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'access_token' => $data['access_token'],
                'expires_in' => $data['expires_in'],
            ];
        }

        return null;
    }

    /**
     * Get sample Instagram URLs for demo/review purposes
     */
    public function getSampleUrls()
    {
        return [
            'https://www.instagram.com/p/DR5UD8VkZY6/', // Instagram official account
            'https://www.instagram.com/p/DRiGIV1Ebg1/', // Instagram official account
            'https://www.instagram.com/p/DSA_KX8kUfd/', // Instagram official account
            'https://www.instagram.com/p/DRGsYMLjLFp/', // Instagram official account
            'https://www.instagram.com/p/DRASIPVAJY8/', // Instagram official account
            'https://www.instagram.com/p/DQZ3c_akY1F/', // Instagram official account
        ];
    }


    /**
     * Get post data from public Instagram URLs using oEmbed
     * No authentication required for public posts
     */
    public function getPostFromUrl($instagramUrl)
    {
        $cacheKey = "instagram_oembed_" . md5($instagramUrl);
        
        return Cache::remember($cacheKey, 3600, function () use ($instagramUrl) {
            // Generate a unique color for each post based on URL
            $colors = ['E1306C', 'C13584', '833AB4', 'FD1D1D', 'F56040', 'FCAF45'];
            $colorIndex = abs(crc32($instagramUrl)) % count($colors);
            
            $placeholder = [
                'id' => md5($instagramUrl),
                'image_url' => 'https://placehold.co/600x600/' . $colors[$colorIndex] . '/ffffff?text=Instagram',
                'permalink' => $instagramUrl,
                'caption' => 'Instagram Post',
                'type' => 'IMAGE',
                'timestamp' => now()->toIso8601String(),
            ];
            
            $data = $this->fetchOembed($instagramUrl);

            if (!empty($data['thumbnail_url'])) {
                return [
                    'id' => md5($instagramUrl),
                    'image_url' => $data['thumbnail_url'],
                    'permalink' => $instagramUrl,
                    'caption' => $data['title'] ?? '',
                    'type' => 'IMAGE',
                    'timestamp' => now()->toIso8601String(),
                ];
            }

            // Always return placeholder if API fails
            return $placeholder;
        });
    }

    /**
     * Call the oEmbed endpoint for a post.
     *
     * Without app credentials this endpoint still answers, but only with the
     * embed HTML - thumbnail_url is only returned for authenticated calls, so
     * there is no point spending the request.
     *
     * @return array|null
     */
    protected function fetchOembed($instagramUrl)
    {
        $appId = config('services.meta.app_id');
        $appSecret = config('services.meta.app_secret');

        $params = [
            'url' => $instagramUrl,
            'maxwidth' => 600,
            'omitscript' => true,
        ];

        if (!empty($appId) && !empty($appSecret)) {
            $params['access_token'] = "{$appId}|{$appSecret}";
        }

        try {
            $response = Http::timeout(10)->get('https://graph.facebook.com/v18.0/instagram_oembed', $params);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * The shortcode part of a post URL, e.g. "ABC123" in /p/ABC123/
     *
     * @return string|null
     */
    protected function shortcodeFromUrl($instagramUrl)
    {
        return preg_match('#instagram\.com/(?:p|reel|reels|tv)/([A-Za-z0-9_\-]+)#i', $instagramUrl, $matches)
            ? $matches[1]
            : null;
    }

    /**
     * Instagram's own iframe embed URL for a post. Needs no authentication.
     *
     * @return string|null
     */
    public function embedUrl($instagramUrl)
    {
        $shortcode = $this->shortcodeFromUrl($instagramUrl);

        return $shortcode ? "https://www.instagram.com/p/{$shortcode}/embed/captioned/" : null;
    }

    /**
     * Undocumented redirect to the full-size photo of a post. Needs no
     * authentication, but only works under /p/ - not /reel/ - and Meta may
     * withdraw it, hence the config flag.
     *
     * @return string|null
     */
    public function mediaUrl($instagramUrl, $size = 'l')
    {
        $shortcode = $this->shortcodeFromUrl($instagramUrl);

        return $shortcode ? "https://www.instagram.com/p/{$shortcode}/media/?size={$size}" : null;
    }

    /**
     * Get multiple posts from URLs
     */
    public function getPostsFromUrls(array $urls)
    {
        return collect($urls)
            ->map(fn($url) => $this->getPostFromUrl($url))
            ->filter()
            ->values()
            ->toArray();
    }

    /**
     * Get sample posts from Instagram's official account
     * Uses oEmbed API with sample URLs
     */
    public function getSamplePosts($limit = 6)
    {
        $sampleUrls = array_slice($this->getSampleUrls(), 0, $limit);
        $posts = $this->getPostsFromUrls($sampleUrls);
        
        Log::info('Sample posts retrieved', ['count' => count($posts)]);
        
        return $posts;
    }

    /**
     * Get the hand-curated posts listed in the carousel source file.
     *
     * Used until the Meta API integration is live: post links (or pasted
     * embed code) are kept in a text file, see config('social.instagram_carousel').
     *
     * @param int|null $limit
     * @return array
     */
    public function getCuratedPosts($limit = null)
    {
        $path = config('social.instagram_carousel.source');
        $limit = $limit ?? config('social.instagram_carousel.limit', 10);

        if (empty($path) || !is_file($path) || !is_readable($path)) {
            Log::warning('Instagram carousel source file missing', ['path' => $path]);
            return [];
        }

        // filemtime in the key means edits to the file show up straight away
        $cacheKey = 'instagram_curated_' . md5($path) . '_' . filemtime($path) . "_{$limit}";

        return Cache::remember($cacheKey, config('social.instagram_carousel.cache_ttl', 3600), function () use ($path, $limit) {
            return collect($this->parseCuratedFile(file_get_contents($path)))
                ->unique('url')
                ->take($limit)
                ->map(fn($entry) => $this->buildCuratedPost($entry))
                ->values()
                ->toArray();
        });
    }

    /**
     * Turn the contents of the carousel source file into post entries.
     *
     * Each entry is one of:
     *   - a post link, optionally followed by "| image | caption"
     *   - a block of pasted Instagram embed HTML (may span several lines)
     *
     * @return array<int, array{url: string, image: ?string, caption: ?string}>
     */
    protected function parseCuratedFile($contents)
    {
        $entries = [];
        $htmlBlock = null;

        foreach (preg_split('/\R/', $contents) as $line) {
            $line = trim($line);

            // Inside a pasted embed block: collect until the closing tag
            if ($htmlBlock !== null) {
                $htmlBlock .= ' ' . $line;

                if (Str::contains($line, '</blockquote>')) {
                    if ($entry = $this->parseCuratedEntry($htmlBlock)) {
                        $entries[] = $entry;
                    }
                    $htmlBlock = null;
                }

                continue;
            }

            if ($line === '' || Str::startsWith($line, '#')) {
                continue;
            }

            if (Str::contains($line, '<blockquote') && !Str::contains($line, '</blockquote>')) {
                $htmlBlock = $line;
                continue;
            }

            if ($entry = $this->parseCuratedEntry($line)) {
                $entries[] = $entry;
            }
        }

        // Unterminated embed block - take whatever we got
        if ($htmlBlock !== null && $entry = $this->parseCuratedEntry($htmlBlock)) {
            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * Pull the post URL (and optional image / caption) out of a single entry.
     *
     * @return array{url: string, image: ?string, caption: ?string}|null
     */
    protected function parseCuratedEntry($entry)
    {
        $isHtml = Str::contains($entry, '<');
        $parts = $isHtml ? [$entry] : array_map('trim', explode('|', $entry));

        if (!preg_match('#https?://(?:www\.)?instagram\.com/(?:p|reel|reels|tv)/[A-Za-z0-9_\-]+#i', $parts[0], $matches)) {
            Log::warning('Skipping unparseable Instagram carousel entry', ['entry' => Str::limit($entry, 120)]);
            return null;
        }

        return [
            'url' => $matches[0] . '/',
            'image' => $isHtml ? null : ($parts[1] ?? null ?: null),
            'caption' => $isHtml ? null : ($parts[2] ?? null ?: null),
            'embed_html' => $isHtml ? $entry : null,   // <-- keep it
        ];
    }

    /**
     * Build a carousel-ready post from a curated entry.
     *
     * In 'embed' mode only the permalink matters - Instagram's iframe renders
     * the post itself. In 'image' mode we need a photo URL, so work down the
     * fallbacks documented in config/social.php.
     */
    protected function buildCuratedPost(array $entry)
    {
        $url = $entry['url'];
        $needsOembed = empty($entry['image']) && empty($entry['embed_html']);
        $oembed = $needsOembed ? $this->fetchOembed($url) : null;

        return [
            'id' => md5($url),
            'image_url' => $this->curatedImageUrl($entry, $oembed),
            'permalink' => $url,
            'embed_url' => $this->embedUrl($url),
            'embed_html' => $entry['embed_html'] ?? ($oembed['html'] ?? null),
            'caption' => $entry['caption'] ?? $oembed['title'] ?? '',
            'type' => 'IMAGE',
            'timestamp' => null,
        ];
    }

    /**
     * Work out which photo to show for a curated post.
     */
    protected function curatedImageUrl(array $entry, $oembed = null)
    {
        if (!empty($entry['image'])) {
            return Str::startsWith($entry['image'], ['http://', 'https://', '//'])
                ? $entry['image']
                : asset(ltrim($entry['image'], '/'));
        }

        if (!empty($oembed['thumbnail_url'])) {
            return $oembed['thumbnail_url'];
        }

        if (config('social.instagram_carousel.media_hotlink', true) && $media = $this->mediaUrl($entry['url'])) {
            return $media;
        }

        // Last resort: a coloured tile, so a bad entry is obvious rather than broken
        $colors = ['E1306C', 'C13584', '833AB4', 'FD1D1D', 'F56040', 'FCAF45'];

        return 'https://placehold.co/600x600/'
            . $colors[abs(crc32($entry['url'])) % count($colors)]
            . '/ffffff?text=Instagram';
    }

    /**
     * Get posts - tries real API first, falls back to sample posts
     */
    public function getPosts($limit = 10, $useSamples = false)
    {
        if ($useSamples || empty($this->accessToken) || $this->accessToken === 'your_instagram_access_token') {
            return $this->getSamplePosts($limit);
        }

        $posts = $this->getLatestPosts($limit);
        
        // Fallback to samples if API fails
        if (empty($posts)) {
            Log::info('Falling back to sample Instagram posts');
            return $this->getSamplePosts($limit);
        }

        return $posts;
    }

}