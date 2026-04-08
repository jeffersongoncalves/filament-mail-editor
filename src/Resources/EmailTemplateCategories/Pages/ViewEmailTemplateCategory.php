<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\EmailTemplateCategoryResource;

class ViewEmailTemplateCategory extends ViewRecord
{
    protected static string $resource = EmailTemplateCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
