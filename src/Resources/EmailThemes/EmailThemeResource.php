<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTheme;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Schemas\EmailThemeForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Schemas\EmailThemeInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Tables\EmailThemesTable;

class EmailThemeResource extends Resource
{
    protected static ?string $model = EmailTheme::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-mail-editor::filament-mail-editor.navigation.themes_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_theme.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_theme.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_theme.plural_model_label');
    }

    public static function form(Form $form): Form
    {
        return EmailThemeForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return EmailThemeInfolist::configure($infolist);
    }

    public static function table(Table $table): Table
    {
        return EmailThemesTable::configure($table);
    }

    public static function canDelete(Model $record): bool
    {
        if ($record instanceof EmailTheme && $record->is_system) {
            return false;
        }

        return parent::canDelete($record);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailThemes::route('/'),
            'create' => Pages\CreateEmailTheme::route('/create'),
            'view' => Pages\ViewEmailTheme::route('/{record}'),
            'edit' => Pages\EditEmailTheme::route('/{record}/edit'),
        ];
    }
}
