<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */

    'default' => env('FILESYSTEM_DISK', 'local'), // Keep 'local' as the default

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            // --- Standard 'local' disk usually points here ---
            'root' => storage_path('app'), // Default non-public storage root
            'throw' => false,
        ],

        // --- ADDED 'private' DISK CONFIGURATION ---
        'private' => [
            'driver' => 'local',                 // Use the local filesystem driver
            'root' => storage_path('app/private'), // Store files in storage/app/private
                                                 // This directory is NOT linked publicly
            // 'visibility' => 'private',        // Optional: Default visibility for local driver
            'throw' => false,                    // Prevent exceptions on file errors
        ],
        // --- END OF ADDED 'private' DISK ---


        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'), // Files stored here before linking
            'url' => env('APP_URL').'/storage',  // Base URL for public access after linking
            'visibility' => 'public', // Ensure files are readable
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */

    'links' => [
        // Links public/storage -> storage/app/public (Keep this)
        public_path('storage') => storage_path('app/public'),
    ],

];