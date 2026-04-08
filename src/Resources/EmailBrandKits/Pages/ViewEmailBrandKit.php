<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailBrandKit;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\EmailBrandKitResource;

class ViewEmailBrandKit extends ViewRecord
{
    protected static string $resource = EmailBrandKitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('setDefault')
                ->icon('heroicon-m-star')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn () => ! ($this->record instanceof EmailBrandKit && $this->record->is_default))
                ->action(function () {
                    /** @var EmailBrandKit $record */
                    $record = $this->record;
                    $record->setAsDefault();
                    $this->refreshFormData(['is_default']);
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
