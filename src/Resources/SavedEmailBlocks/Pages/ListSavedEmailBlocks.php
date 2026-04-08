<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\SavedEmailBlockResource;

class ListSavedEmailBlocks extends ListRecords
{
    protected static string $resource = SavedEmailBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
