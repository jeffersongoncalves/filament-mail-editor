<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
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

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.set_default'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.set_default'))
            ->icon(Heroicon::OutlinedStar)
            ->color('warning')
            ->requiresConfirmation()
            ->visible(fn (EmailTheme $record): bool => ! $record->is_default)
            ->action(fn (EmailTheme $record) => $record->setAsDefault());
    }
}
