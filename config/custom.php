<?php

return [
    'app' => [
        'owner' => [
            'name' => env('APP_OWNER', 'Kennedy Osaze'),
            'url' => env('APP_OWNER_URL', '#'),
        ]
    ],

    'forms' => [
        'max_no_user_unclosed_forms' => 10,
        'min_no_title_words' => 1,
        'max_no_title_words' => 10,
        'min_no_description_words' => 3,
        'max_no_description_words' => 100,

    ],
];
