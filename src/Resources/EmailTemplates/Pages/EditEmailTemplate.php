<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\DuplicateAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class EditEmailTemplate extends EditRecord
{
    protected static string $resource = EmailTemplateResource::class;

    protected string $view = 'filament-mail-editor::resources.email-templates.pages.edit-email-template';

    protected function getHeaderActions(): array
    {
        return [
            DuplicateAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
