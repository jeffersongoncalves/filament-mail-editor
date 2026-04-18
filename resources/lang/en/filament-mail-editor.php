<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        'group' => 'Mail Editor',
        'email_templates' => 'Email Templates',
        'template_categories' => 'Template Categories',
        'brand_kits' => 'Brand Kits',
        'saved_blocks' => 'Saved Blocks',
    ],

    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    */
    'builder' => [
        'heading' => 'Email Builder',
        'description' => 'Drag and drop blocks to build your email template.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Labels
    |--------------------------------------------------------------------------
    */
    'resource' => [
        'email_template' => [
            'navigation_label' => 'Email Templates',
            'model_label' => 'Email Template',
            'plural_model_label' => 'Email Templates',
        ],
        'email_template_category' => [
            'navigation_label' => 'Template Categories',
            'model_label' => 'Template Category',
            'plural_model_label' => 'Template Categories',
        ],
        'email_brand_kit' => [
            'navigation_label' => 'Brand Kits',
            'model_label' => 'Brand Kit',
            'plural_model_label' => 'Brand Kits',
        ],
        'saved_email_block' => [
            'navigation_label' => 'Saved Blocks',
            'model_label' => 'Saved Block',
            'plural_model_label' => 'Saved Blocks',
        ],
    ],

];
