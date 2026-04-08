<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\EmailTemplateCategoryResource;

class CreateEmailTemplateCategory extends CreateRecord
{
    protected static string $resource = EmailTemplateCategoryResource::class;
}
