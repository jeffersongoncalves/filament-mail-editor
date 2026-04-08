<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\EmailBrandKitResource;

class ListEmailBrandKits extends ListRecords
{
    protected static string $resource = EmailBrandKitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
