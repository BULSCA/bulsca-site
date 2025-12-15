<?php

return [
    'enabled' => env('SSO_ENABLED', true),
    'auth_server' => env('SSO_AUTH_SERVER'),
    'client_id' => env('SSO_CLIENT_ID'),
    'client_secret' => env('SSO_CLIENT_SECRET'),
    'redirect_uri' => env('APP_URL') . '/auth/sso/callback',
    'site_identifier' => env('SITE_IDENTIFIER', 'main'),
    
    // Scopes accepted by this site (empty = accept any)
    // Can be comma-separated in env: "admin,official,member"
    'accepted_scopes' => array_filter(explode(',', env('SSO_ACCEPTED_SCOPES', ''))),
    
    // Available scope presets for this site to grant
    'scope_presets' => [
        'Admin' => ['admin'],
        'Official' => ['official'],
        'Member' => ['member'],
        'Results Uploader' => ['results_uploader'],
        'Competition Official' => ['competition_official'],
    ],

    /*
    'scope_presets' => [
        'Admin Bundle' => ['admin', 'official', 'member'],
        'Official Bundle' => ['official', 'member'],
        'Basic Member' => ['member'],
        'Results Manager' => ['results_uploader', 'member'],
        'Competition Staff' => ['competition_official', 'member'],
    ],
    */ 
];