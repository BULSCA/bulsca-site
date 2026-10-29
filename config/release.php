<?php

return [
    'trusted_proxies' => array_values(array_filter(array_map('trim', explode(',', env('TRUSTED_PROXIES', ''))))),
    'writable_paths' => [storage_path('app'), storage_path('framework/cache/data'), storage_path('framework/sessions'), storage_path('framework/views'), storage_path('logs'), base_path('bootstrap/cache')],
];
