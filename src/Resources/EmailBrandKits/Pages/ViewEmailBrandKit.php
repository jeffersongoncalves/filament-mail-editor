<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Actions\SetDefaultAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\EmailBrandKitResource;

class ViewEmailBrandKit extends ViewRecord
{
    protected static string $resource = EmailBrandKitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            SetDefaultAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
