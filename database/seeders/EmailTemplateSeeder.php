<?php

declare(strict_types=1);

namespace JeffersonGoncalves\FilamentMailEditor\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateCategory;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplateCategory as CategoryModel;

final class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Welcome Email',
                'slug' => 'welcome-email',
                'subject' => 'Welcome to {{company_name}}!',
                'preheader' => 'Get started with your new account',
                'category' => TemplateCategory::Transactional,
                'category_slug' => 'transactional',
                'blocks' => [
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'header',
                        'props' => ['logo_url' => '', 'logo_alt' => 'Logo'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'heading',
                        'props' => ['text' => 'Welcome, {{user_name}}!', 'level' => 'h1'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'paragraph',
                        'props' => ['text' => 'Thanks for joining us. We\'re excited to have you on board.'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'button',
                        'props' => ['text' => 'Get Started', 'url' => '{{app_url}}'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'footer',
                        'props' => ['address' => '{{company_address}}'],
                    ],
                ],
            ],
            [
                'name' => 'Promotional Campaign',
                'slug' => 'promotional-campaign',
                'subject' => '{{discount}}% off — Limited time only',
                'preheader' => 'Don\'t miss our biggest sale of the year',
                'category' => TemplateCategory::Marketing,
                'category_slug' => 'marketing',
                'blocks' => [
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'preheader',
                        'props' => ['text' => 'Exclusive offer inside'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'hero',
                        'props' => [
                            'title' => 'Mega Sale',
                            'subtitle' => 'Up to {{discount}}% off storewide',
                            'cta_text' => 'Shop Now',
                            'cta_url' => '{{shop_url}}',
                        ],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'paragraph',
                        'props' => ['text' => 'Hurry — offer ends {{end_date}}.'],
                    ],
                ],
            ],
            [
                'name' => 'Password Reset',
                'slug' => 'password-reset',
                'subject' => 'Reset your password',
                'preheader' => 'We received a request to reset your password',
                'category' => TemplateCategory::Transactional,
                'category_slug' => 'transactional',
                'blocks' => [
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'heading',
                        'props' => ['text' => 'Password Reset Request', 'level' => 'h1'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'paragraph',
                        'props' => ['text' => 'Hi {{user_name}}, click the button below to reset your password.'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'button',
                        'props' => ['text' => 'Reset Password', 'url' => '{{reset_url}}'],
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'type' => 'alert',
                        'props' => ['text' => 'If you didn\'t request this, ignore this email.', 'variant' => 'warning'],
                    ],
                ],
            ],
        ];

        foreach ($templates as $template) {
            $categorySlug = $template['category_slug'];
            unset($template['category_slug']);

            $category = CategoryModel::query()->where('slug', $categorySlug)->first();
            $template['category_id'] = $category?->id;
            $template['settings'] = ['primary_color' => '#3b82f6'];
            $template['status'] = TemplateStatus::Draft;
            $template['is_active'] = true;

            EmailTemplate::firstOrCreate(
                ['slug' => $template['slug']],
                $template,
            );
        }
    }
}
