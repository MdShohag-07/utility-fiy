<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    'public_path' => null,  // Override the public path if needed (usually not necessary)

    /*
     * Dejavu Sans font is missing glyphs for converted entities, turn it off if you need to show € and £.
     */
    'convert_entities' => true,

    'options' => [
        /**
         * The location of the DOMPDF font directory.
         * Note: This directory (storage/fonts/) must exist and be writable by the webserver.
         */
        'font_dir' => storage_path('fonts'),

        /**
         * The location of the DOMPDF font cache directory.
         * Note: This directory (storage/fonts/) must exist and be writable.
         */
        'font_cache' => storage_path('fonts'),

        /**
         * The location of a temporary directory.
         * Note: This directory must exist and be writable.
         */
        'temp_dir' => sys_get_temp_dir(),

        /**
         * dompdf's "chroot": Prevents dompdf from accessing system files outside
         * your project's base path. This is a security measure.
         */
        'chroot' => realpath(base_path()),

        /**
         * Protocol whitelist
         * Allows dompdf to access resources via these protocols.
         * 'data://' is important for base64 embedded images.
         */
        'allowed_protocols' => [
            'data://' => ['rules' => []],
            'file://' => ['rules' => []], // Be cautious with file:// on production
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        'artifactPathValidation' => null,
        'log_output_file' => null, // Or storage_path('logs/dompdf.html') for debugging rendering

        'enable_font_subsetting' => false, // Or true to reduce file size if fonts are embedded

        'pdf_backend' => 'CPDF', // CPDF is bundled; PDFLib requires separate installation

        'default_media_type' => 'print', // Usually 'print' is more appropriate for PDFs

        'default_paper_size' => 'letter', // Or 'a4' etc.
        'default_paper_orientation' => 'portrait',
        'default_font' => 'DejaVu Sans', // Recommended for good character support

        'dpi' => 96, // Standard DPI

        'enable_php' => false, // SECURITY: Keep false unless absolutely necessary and trusted content

        'enable_javascript' => false, // PDF JavaScript is different from browser JS; usually false

        /**
         * Enable remote file access.
         * SECURITY: Set to 'false' for production unless you specifically need to load images/CSS
         * from remote URLs. If true, also configure 'allowed_remote_hosts'.
         * Base64 embedding images or using local paths (if chroot allows) is safer.
         */
        'enable_remote' => false, // *** Recommended to keep FALSE for security ***

        'allowed_remote_hosts' => null, // Only relevant if 'enable_remote' is true

        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true, // Should be true
        'isPhpEnabled' => false, // Alias for enable_php
        'isRemoteEnabled' => false, // *** Ensure this matches 'enable_remote' for consistency ***
        'isJavascriptEnabled' => false, // Alias for enable_javascript
        'isHtml5ParserEnabled' => true, // Alias for enable_html5_parser
        'isFontSubsettingEnabled' => false, // Alias for enable_font_subsetting
    ],

];