<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\SavedEmailBlockResource;

class ViewSavedEmailBlock extends ViewRecord
{
    protected static string $resource = SavedEmailBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
