<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Instagram Carousel
    |--------------------------------------------------------------------------
    |
    | Until the Meta API integration is in place, the carousel is populated by
    | hand from a plain text file of Instagram post links / pasted embed code.
    | See the header of the source file for the accepted formats.
    |
    */

    'instagram_carousel' => [

        // Master on/off switch for the carousel (landing page and anywhere else).
        'enabled' => env('INSTAGRAM_CAROUSEL_ENABLED', false),

        // Heading shown above the carousel.
        'title' => env('INSTAGRAM_CAROUSEL_TITLE', 'Latest from BULSCA Instagram'),

        // How each post is rendered:
        //   'image' - our own square photo cards (needs a photo per post, see below)
        //   'embed' - Instagram's own iframe embed: real post, likes and caption,
        //             no API access required, but Instagram controls the styling
        'mode' => env('INSTAGRAM_CAROUSEL_MODE', 'image'),

        // In 'image' mode, where the photo comes from, in order of preference:
        //   1. the image column in the source file
        //   2. the oEmbed thumbnail, if META_APP_ID / META_APP_SECRET are set
        //   3. instagram.com/p/<code>/media/?size=l  (no auth, but undocumented -
        //      Meta can break it at any time; disable with the flag below)
        //   4. a placeholder tile
        'media_hotlink' => (bool) env('INSTAGRAM_CAROUSEL_MEDIA_HOTLINK', true),

        // Text file the posts are read from.
        'source' => env('INSTAGRAM_CAROUSEL_SOURCE', resource_path('data/instagram-posts.txt')),

        // Maximum number of posts to show.
        'limit' => (int) env('INSTAGRAM_CAROUSEL_LIMIT', 10),

        // How long parsed posts / oEmbed lookups are cached for, in seconds.
        // Editing the source file busts the cache immediately regardless of this.
        'cache_ttl' => (int) env('INSTAGRAM_CAROUSEL_CACHE_TTL', 3600),
    ],

];
