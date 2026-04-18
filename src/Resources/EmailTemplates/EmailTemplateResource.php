<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas\EmailTemplateForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas\EmailTemplateInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Tables\EmailTemplatesTable;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-mail-editor.navigation_group'));
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return EmailTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmailTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailTemplates::route('/'),
            'create' => Pages\CreateEmailTemplate::route('/create'),
            'view' => Pages\ViewEmailTemplate::route('/{record}'),
            'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
        ];
    }
}
