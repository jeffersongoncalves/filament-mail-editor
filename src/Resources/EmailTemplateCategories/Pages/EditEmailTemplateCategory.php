<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\EmailTemplateCategoryResource;

class EditEmailTemplateCategory extends EditRecord
{
    protected static string $resource = EmailTemplateCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
