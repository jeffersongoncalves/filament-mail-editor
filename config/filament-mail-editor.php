<?php

use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

return [
    'table_name' => 'email_templates',

    'model' => EmailTemplate::class,

    'default_settings' => [
        'primary_color' => '#378ADD',
        'bg_color' => '#f8f9fa',
        'font_family' => 'Arial, sans-serif',
    ],

    'preview_route_middleware' => ['web', 'auth'],

    'blocks' => [],
];
