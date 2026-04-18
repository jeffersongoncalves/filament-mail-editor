<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navegação
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        'group' => 'Editor de E-mail',
        'themes_group' => 'Temas de E-mail',
        'email_templates' => 'Modelos de E-mail',
        'template_categories' => 'Categorias de Modelos',
        'brand_kits' => 'Kits de Marca',
        'saved_blocks' => 'Blocos Salvos',
        'themes' => 'Temas',
    ],

    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    */
    'builder' => [
        'heading' => 'Construtor de E-mail',
        'description' => 'Arraste e solte blocos para montar seu modelo de e-mail.',
        'back_to_edit' => 'Voltar para Edição',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ações
    |--------------------------------------------------------------------------
    */
    'actions' => [
        'duplicate' => 'Duplicar',
        'export_json' => 'Exportar JSON',
        'export_html' => 'Exportar HTML',
        'submit_for_review' => 'Enviar para Revisão',
        'approve' => 'Aprovar',
        'reject_to_draft' => 'Voltar para Rascunho',
        'workflow' => 'Fluxo',
        'set_default' => 'Definir como Padrão',
        'open_builder' => 'Abrir Construtor',
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
        'email_theme' => [
            'navigation_label' => 'Temas',
            'model_label' => 'Tema',
            'plural_model_label' => 'Temas',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Campos (colunas e entradas de formulário)
    |--------------------------------------------------------------------------
    */
    'fields' => [
        'name' => 'Nome',
        'slug' => 'Slug',
        'subject' => 'Assunto',
        'preheader' => 'Preheader',
        'category' => 'Categoria',
        'status' => 'Status',
        'is_active' => 'Ativo',
        'is_default' => 'Padrão',
        'is_system' => 'Sistema',
        'is_global' => 'Global',
        'description' => 'Descrição',
        'color' => 'Cor',
        'icon' => 'Ícone',
        'parent' => 'Pai',
        'sort_order' => 'Ordem',
        'logo_url' => 'URL do Logo',
        'logo_alt' => 'Texto Alternativo do Logo',
        'footer_address' => 'Endereço do Rodapé',
        'unsubscribe_url' => 'URL de Descadastro',
        'primary_color' => 'Cor Primária',
        'secondary_color' => 'Cor Secundária',
        'accent_color' => 'Cor de Destaque',
        'bg_color' => 'Cor de Fundo',
        'content_bg' => 'Fundo do Conteúdo',
        'text_color' => 'Cor do Texto',
        'muted_color' => 'Cor Suavizada',
        'button_bg' => 'Fundo do Botão',
        'button_text' => 'Cor do Texto do Botão',
        'font_family' => 'Família da Fonte',
        'font_size_base' => 'Tamanho Base da Fonte',
        'line_height_base' => 'Altura de Linha Base',
        'border_radius' => 'Raio da Borda',
        'social_links' => 'Links Sociais',
        'platform' => 'Plataforma',
        'url' => 'URL',
        'type' => 'Tipo',
        'thumbnail' => 'Miniatura',
        'user_id' => 'Dono',
        'blocks' => 'Blocos',
        'blocks_count' => 'Blocos',
        'updated_at' => 'Atualizado',
        'created_at' => 'Criado',
        'approved_by' => 'Aprovado Por',
        'approved_at' => 'Aprovado Em',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enums
    |--------------------------------------------------------------------------
    */
    'template_status' => [
        'draft' => 'Rascunho',
        'review' => 'Em Revisão',
        'approved' => 'Aprovado',
    ],
    'template_categories' => [
        'transactional' => 'Transacional',
        'marketing' => 'Marketing',
        'notification' => 'Notificação',
    ],
    'block_categories' => [
        'structure' => 'Estrutura',
        'content' => 'Conteúdo',
        'marketing' => 'Marketing',
    ],
    'activity_actions' => [
        'created' => 'Criado',
        'updated' => 'Atualizado',
        'approved' => 'Aprovado',
        'rejected' => 'Rejeitado',
        'submitted_for_review' => 'Enviado para Revisão',
        'exported' => 'Exportado',
        'locked' => 'Bloqueado',
        'unlocked' => 'Desbloqueado',
        'version_created' => 'Versão Criada',
        'version_restored' => 'Versão Restaurada',
        'test_sent' => 'E-mail de Teste Enviado',
        'brand_kit_applied' => 'Kit de Marca Aplicado',
        'theme_applied' => 'Tema Aplicado',
        'imported' => 'Importado',
    ],
    'notification_types' => [
        'submitted_for_review' => 'Enviado para Revisão',
        'approved' => 'Aprovado',
        'rejected' => 'Rejeitado',
    ],
    'schedule_statuses' => [
        'pending' => 'Pendente',
        'processing' => 'Processando',
        'sent' => 'Enviado',
        'failed' => 'Falhou',
        'cancelled' => 'Cancelado',
    ],

    /*
    |--------------------------------------------------------------------------
    | Seções
    |--------------------------------------------------------------------------
    */
    'sections' => [
        'metadata' => 'Metadados',
        'identification' => 'Identificação',
        'branding' => 'Identidade Visual',
        'colors' => 'Cores',
        'typography' => 'Tipografia',
        'social' => 'Social',
        'footer' => 'Rodapé',
        'block' => 'Bloco',
    ],

];
