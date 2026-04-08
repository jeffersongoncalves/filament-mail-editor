<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\EmailBrandKitResource;

class EditEmailBrandKit extends EditRecord
{
    protected static string $resource = EmailBrandKitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
