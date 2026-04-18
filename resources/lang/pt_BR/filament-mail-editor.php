<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navegação
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        'group' => 'Editor de E-mail',
        'email_templates' => 'Modelos de E-mail',
        'template_categories' => 'Categorias de Modelos',
        'brand_kits' => 'Kits de Marca',
        'saved_blocks' => 'Blocos Salvos',
    ],

    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    */
    'builder' => [
        'heading' => 'Construtor de E-mail',
        'description' => 'Arraste e solte blocos para montar seu modelo de e-mail.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rótulos dos Resources
    |--------------------------------------------------------------------------
    */
    'resource' => [
        'email_template' => [
            'navigation_label' => 'Modelos de E-mail',
            'model_label' => 'Modelo de E-mail',
            'plural_model_label' => 'Modelos de E-mail',
        ],
        'email_template_category' => [
            'navigation_label' => 'Categorias de Modelos',
            'model_label' => 'Categoria de Modelo',
            'plural_model_label' => 'Categorias de Modelos',
        ],
        'email_brand_kit' => [
            'navigation_label' => 'Kits de Marca',
            'model_label' => 'Kit de Marca',
            'plural_model_label' => 'Kits de Marca',
        ],
        'saved_email_block' => [
            'navigation_label' => 'Blocos Salvos',
            'model_label' => 'Bloco Salvo',
            'plural_model_label' => 'Blocos Salvos',
        ],
    ],

];
