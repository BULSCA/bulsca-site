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
     * Get a long-lived access token (lasts ~60 days)
     * Call this once to exchange your short-lived token for a long-lived one
     */
    public function getLongLivedToken($shortLivedToken)
    {
        $response = Http::get('https://graph.facebook.com/v24.0/oauth/access_token', [
            'grant_type' => 'fb_exchange_token',
            'client_id' => config('services.meta.app_id'),
            'client_secret' => config('services.meta.app_secret'),
            'fb_exchange_token' => $shortLivedToken,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'access_token' => $data['access_token'],
                'expires_in' => $data['expires_in'], // ~5184000 (60 days)
            ];
        }

        Log::error('Meta long-lived token exchange failed', ['response' => $response->json()]);
        return null;
    }

    /**
     * Refresh a long-lived token before it expires.
     * Facebook Login for Business tokens don't have a separate refresh grant —
     * running the same exchange again with the current token resets the clock,
     * as long as it hasn't already expired.
     */
    public function refreshToken($currentToken = null)
    {
        return $this->getLongLivedToken($currentToken ?? $this->accessToken);
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

}