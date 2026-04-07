<?php

namespace JeffersonGoncalves\FilamentMailEditor;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class FilamentMailEditorPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static */
        return filament(app(static::class)->getId());
    }

    public function getId(): string
    {
        return 'filament-mail-editor';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            EmailTemplateResource::class,
        ]);
    }

    public function boot(Panel $panel): void {}
}
