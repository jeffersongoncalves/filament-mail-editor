<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Actions;

use Filament\Actions\Action;
use Filament\Actions\MountableAction;
use JeffersonGoncalves\MailEditor\Models\EmailTheme;

class SetDefaultAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'setDefault';
    }

    protected function setUp(): void
    {
        parent::setUp();

        static::configureAction($this);
    }

    /** Shared with {@see SetDefaultTableAction}: Filament 3 tables need Filament\Tables\Actions\Action. */
    public static function configureAction(MountableAction $action): void
    {
        $action
            ->label(__('filament-mail-editor::filament-mail-editor.actions.set_default'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.set_default'))
            ->icon('heroicon-o-star')
            ->color('warning')
            ->requiresConfirmation()
            ->visible(fn (EmailTheme $record): bool => ! $record->is_default)
            ->action(fn (EmailTheme $record) => $record->setAsDefault());
    }
}
