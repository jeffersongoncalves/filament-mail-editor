<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Actions\SetDefaultAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\EmailThemeResource;
use JeffersonGoncalves\MailEditor\Models\EmailTheme;

class ViewEmailTheme extends ViewRecord
{
    protected static string $resource = EmailThemeResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Actions\EditAction::make(),
            SetDefaultAction::make(),
        ];

        /** @var EmailTheme $record */
        $record = $this->record;

        if (! $record->is_system) {
            $actions[] = Actions\DeleteAction::make();
        }

        return $actions;
    }
}
