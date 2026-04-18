<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\DuplicateAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\OpenBuilderAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class EditEmailTemplate extends EditRecord
{
    protected static string $resource = EmailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            OpenBuilderAction::make(),
            DuplicateAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
