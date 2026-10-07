<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Schemas\EmailTemplateCategoryForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Schemas\EmailTemplateCategoryInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Tables\EmailTemplateCategoriesTable;
use JeffersonGoncalves\MailEditor\Models\EmailTemplateCategory;

class EmailTemplateCategoryResource extends Resource
{
    protected static ?string $model = EmailTemplateCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-mail-editor::filament-mail-editor.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template_category.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template_category.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template_category.plural_model_label');
    }

    public static function form(Form $form): Form
    {
        return EmailTemplateCategoryForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return EmailTemplateCategoryInfolist::configure($infolist);
    }

    public static function table(Table $table): Table
    {
        return EmailTemplateCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailTemplateCategories::route('/'),
            'create' => Pages\CreateEmailTemplateCategory::route('/create'),
            'view' => Pages\ViewEmailTemplateCategory::route('/{record}'),
            'edit' => Pages\EditEmailTemplateCategory::route('/{record}/edit'),
        ];
    }
}
