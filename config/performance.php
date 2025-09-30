<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Performance Settings
    |--------------------------------------------------------------------------
    |
    | Here you may configure various performance settings for your application.
    | These settings will help optimize the performance of your application.
    |
    */

    'cache' => [
        'enabled' => env('APP_CACHE_ENABLED', true),
        'default_ttl' => env('APP_CACHE_TTL', 1800), // 30 minutes
        
        'keys' => [
            'dashboard_statistics' => env('CACHE_DASHBOARD_TTL', 3600), // 1 hour
            'kategoris_all' => env('CACHE_KATEGORIS_TTL', 1800),        // 30 minutes
            'lokasis_all' => env('CACHE_LOKASIS_TTL', 1800),            // 30 minutes
            'barangs_available_for_loan' => env('CACHE_BARANGS_LOAN_TTL', 300), // 5 minutes
            'barang_statistics' => env('CACHE_BARANG_STATS_TTL', 1800), // 30 minutes
        ],
    ],

    'database' => [
        'chunk_size' => env('DB_CHUNK_SIZE', 100),
        'pagination_size' => env('DB_PAGINATION_SIZE', 15),
        'max_execution_time' => env('DB_MAX_EXECUTION_TIME', 30),
    ],

    'optimization' => [
        'enable_compression' => env('APP_ENABLE_COMPRESSION', true),
        'minify_html' => env('APP_MINIFY_HTML', true),
        'lazy_loading' => env('APP_LAZY_LOADING', true),
        'image_optimization' => env('APP_IMAGE_OPTIMIZATION', true),
    ],

    'monitoring' => [
        'slow_query_threshold' => env('MONITOR_SLOW_QUERY_MS', 1000), // 1 second
        'memory_limit_warning' => env('MONITOR_MEMORY_LIMIT_MB', 128),
        'enable_query_log' => env('MONITOR_ENABLE_QUERY_LOG', false),
    ],
];