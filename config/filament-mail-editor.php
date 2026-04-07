<?php

use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

return [
    'table_name' => 'email_templates',

    'model' => EmailTemplate::class,

    'default_settings' => [
        'primary_color' => '#378ADD',
        'bg_color' => '#f8f9fa',
        'font_family' => 'Arial, sans-serif',
        'dark_bg_color' => '#1a1a1a',
        'dark_text_color' => '#e0e0e0',
    ],

    'preview_route_middleware' => ['web', 'auth'],

    'storage_disk' => 'public',

    'storage_path' => 'email-images',

    'blocks' => [],
];
