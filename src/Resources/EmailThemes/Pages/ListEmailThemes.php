<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\EmailThemeResource;

class ListEmailThemes extends ListRecords
{
    protected static string $resource = EmailThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
