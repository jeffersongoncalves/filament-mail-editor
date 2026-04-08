<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplateCategory;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Schemas\EmailTemplateCategoryForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Schemas\EmailTemplateCategoryInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Tables\EmailTemplateCategoriesTable;

class EmailTemplateCategoryResource extends Resource
{
    protected static ?string $model = EmailTemplateCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    protected static string|\UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return 'Template Categories';
    }

    public static function form(Schema $schema): Schema
    {
        return EmailTemplateCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmailTemplateCategoryInfolist::configure($schema);
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
