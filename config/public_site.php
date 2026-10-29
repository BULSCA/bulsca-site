<?php

return [
    'api_url' => env('PUBLIC_API_URL'),
    'read_limit' => (int) env('PUBLIC_API_RATE_LIMIT', 120),
    'contact_enabled' => (bool) env('CONTACT_FORM_ENABLED', true),
    'cache_store' => env('PUBLIC_API_CACHE_STORE', 'file'),
    // Local files remain authoritative. The API returns URLs, never storage paths.
    'presentation' => [
        'version' => 'public-v1', 'banner_pool' => [], 'banner_overrides' => [], 'campaigns' => [],
        'championship_campaign' => [
            'id' => 'champs-2027', 'title' => 'Champs 2027', 'start_date' => '2027-03-06', 'end_date' => '2027-03-07',
            'location' => 'Alan Higgs Centre, Coventry', 'colours' => ['#070660', '#9e0d06'],
            'link' => ['label' => 'Explore the Championships', 'url' => '/competitions/championships'],
        ],
    ],
    // Published archival content copied from the legacy championship pages.
    'championships' => json_decode(file_get_contents(resource_path('data/championships.json')), true, flags: JSON_THROW_ON_ERROR),
];
