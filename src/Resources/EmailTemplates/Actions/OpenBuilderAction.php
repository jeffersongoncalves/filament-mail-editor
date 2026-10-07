<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Actions\MountableAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class OpenBuilderAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'openBuilder';
    }

    protected function setUp(): void
    {
        parent::setUp();

        static::configureAction($this);
    }

    /** Shared with {@see OpenBuilderTableAction}: Filament 3 tables need Filament\Tables\Actions\Action. */
    public static function configureAction(MountableAction $action): void
    {
        $action
            ->label(__('filament-mail-editor::filament-mail-editor.actions.open_builder'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.open_builder'))
            ->icon('heroicon-o-squares-2x2')
            ->color('primary')
            ->url(fn (EmailTemplate $record): string => EmailTemplateResource::getUrl('build', ['record' => $record]));
    }
}
