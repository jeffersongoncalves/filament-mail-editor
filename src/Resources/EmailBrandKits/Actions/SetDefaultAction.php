<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailBrandKit;

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
            ->icon(Heroicon::OutlinedStar)
            ->color('warning')
            ->requiresConfirmation()
            ->visible(fn (EmailBrandKit $record): bool => ! $record->is_default)
            ->action(fn (EmailBrandKit $record) => $record->setAsDefault());
    }
}
