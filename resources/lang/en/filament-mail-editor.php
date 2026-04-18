<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        'group' => 'Mail Editor',
        'themes_group' => 'Mail Themes',
        'email_templates' => 'Email Templates',
        'template_categories' => 'Template Categories',
        'brand_kits' => 'Brand Kits',
        'saved_blocks' => 'Saved Blocks',
        'themes' => 'Themes',
    ],

    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    */
    'builder' => [
        'heading' => 'Email Builder',
        'description' => 'Drag and drop blocks to build your email template.',
        'back_to_edit' => 'Back to Edit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */
    'actions' => [
        'duplicate' => 'Duplicate',
        'export_json' => 'Export JSON',
        'export_html' => 'Export HTML',
        'submit_for_review' => 'Submit for Review',
        'approve' => 'Approve',
        'reject_to_draft' => 'Return to Draft',
        'workflow' => 'Workflow',
        'set_default' => 'Set as Default',
        'open_builder' => 'Open Builder',
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
        'email_theme' => [
            'navigation_label' => 'Themes',
            'model_label' => 'Theme',
            'plural_model_label' => 'Themes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Fields (columns and form inputs)
    |--------------------------------------------------------------------------
    */
    'fields' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'subject' => 'Subject',
        'preheader' => 'Preheader',
        'category' => 'Category',
        'status' => 'Status',
        'is_active' => 'Active',
        'is_default' => 'Default',
        'is_system' => 'System',
        'is_global' => 'Global',
        'description' => 'Description',
        'color' => 'Color',
        'icon' => 'Icon',
        'parent' => 'Parent',
        'sort_order' => 'Sort Order',
        'logo_url' => 'Logo URL',
        'logo_alt' => 'Logo Alt Text',
        'footer_address' => 'Footer Address',
        'unsubscribe_url' => 'Unsubscribe URL',
        'primary_color' => 'Primary Color',
        'secondary_color' => 'Secondary Color',
        'accent_color' => 'Accent Color',
        'bg_color' => 'Background Color',
        'content_bg' => 'Content Background',
        'text_color' => 'Text Color',
        'muted_color' => 'Muted Color',
        'button_bg' => 'Button Background',
        'button_text' => 'Button Text Color',
        'font_family' => 'Font Family',
        'font_size_base' => 'Base Font Size',
        'line_height_base' => 'Base Line Height',
        'border_radius' => 'Border Radius',
        'social_links' => 'Social Links',
        'platform' => 'Platform',
        'url' => 'URL',
        'type' => 'Type',
        'thumbnail' => 'Thumbnail',
        'user_id' => 'Owner',
        'blocks' => 'Blocks',
        'blocks_count' => 'Blocks',
        'updated_at' => 'Updated',
        'created_at' => 'Created',
        'approved_by' => 'Approved By',
        'approved_at' => 'Approved At',
        'props' => 'Properties',
        'prop_key' => 'Key',
        'prop_value' => 'Value',
        'add_prop' => 'Add property',
        'preheader_helper' => 'Short preview text shown in email clients (max 90 characters).',
        'template_category' => 'Template Folder',
        'none' => 'None',
        'owner' => 'Owner',
        'parent_category' => 'Parent Category',
        'no_description' => 'No description',
        'no_thumbnail' => 'No thumbnail',
        'no_category' => 'No category',
        'no_parent' => 'None (top-level)',
        'thumbnail_url' => 'Thumbnail URL',
        'system_global' => 'System / Global',
        'only_one_default_brand_kit' => 'Only one brand kit can be the default.',
        'company_address' => 'Company Address',
        'font_family_placeholder' => 'Arial, Helvetica, sans-serif',
        'base_font_size_px' => 'Base Font Size (px)',
        'line_height' => 'Line Height',
        'border_radius_px' => 'Border Radius (px)',
        'not_set' => 'Not set',
        'templates' => 'Templates',
        'subcategories' => 'Subcategories',
        'full_path' => 'Full Path',
        'category_free_text' => 'Legacy Type',
        'no_preheader' => 'No preheader set',
        'not_approved' => 'Not approved yet',
        'not_locked' => 'Not locked',
        'not_deleted' => 'Not deleted',
        'blocks_summary' => 'Block Types',
        'blocks_count_summary' => ':count block(s)',
        'total_versions' => 'Total Versions',
        'active_variants' => 'Active Variants',
        'version' => 'Version',
        'reason' => 'Reason',
        'no_reason' => 'No reason',
        'created_by' => 'Created By',
        'system' => 'System',
        'send_percentage' => 'Send %',
        'is_winner' => 'Winner',
        'locked_by' => 'Locked By',
        'locked_at' => 'Locked At',
        'deleted_at' => 'Deleted At',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enums
    |--------------------------------------------------------------------------
    */
    'template_status' => [
        'draft' => 'Draft',
        'review' => 'In Review',
        'approved' => 'Approved',
    ],
    'template_categories' => [
        'transactional' => 'Transactional',
        'marketing' => 'Marketing',
        'notification' => 'Notification',
    ],
    'block_categories' => [
        'structure' => 'Structure',
        'content' => 'Content',
        'marketing' => 'Marketing',
    ],
    'activity_actions' => [
        'created' => 'Created',
        'updated' => 'Updated',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'submitted_for_review' => 'Submitted for Review',
        'exported' => 'Exported',
        'locked' => 'Locked',
        'unlocked' => 'Unlocked',
        'version_created' => 'Version Created',
        'version_restored' => 'Version Restored',
        'test_sent' => 'Test Email Sent',
        'brand_kit_applied' => 'Brand Kit Applied',
        'theme_applied' => 'Theme Applied',
        'imported' => 'Imported',
    ],
    'notification_types' => [
        'submitted_for_review' => 'Submitted for Review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ],
    'notifications' => [
        'template_saved' => 'Template saved successfully.',
        'template_imported' => 'Template imported successfully.',
        'import_failed' => 'Import failed',
        'test_email_sent' => 'Test email sent to :address',
        'brand_kit_applied' => 'Brand kit ":name" applied.',
        'block_saved' => 'Block saved to library.',
        'template_submitted_for_review' => 'Template submitted for review.',
        'template_approved' => 'Template approved.',
        'template_returned_to_draft' => 'Template returned to draft.',
        'version_restored' => 'Template restored to version #:number',
    ],
    'schedule_statuses' => [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'sent' => 'Sent',
        'failed' => 'Failed',
        'cancelled' => 'Cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sections
    |--------------------------------------------------------------------------
    */
    'sections' => [
        'metadata' => 'Metadata',
        'identification' => 'Identification',
        'branding' => 'Branding',
        'colors' => 'Colors',
        'typography' => 'Typography',
        'social' => 'Social',
        'footer' => 'Footer',
        'block' => 'Block',
        'general' => 'General',
        'logo' => 'Logo',
        'appearance' => 'Appearance',
        'timestamps' => 'Timestamps',
        'content' => 'Content',
        'description' => 'Description',
        'properties' => 'Properties',
        'template_details' => 'Template Details',
        'settings' => 'Settings',
        'category_details' => 'Category Details',
        'block_details' => 'Block Details',
        'usage' => 'Usage',
        'status_workflow' => 'Status & Workflow',
        'version_history' => 'Version History',
        'variants' => 'Variants (A/B Testing)',
        'social_links' => 'Social Links',
    ],

];
