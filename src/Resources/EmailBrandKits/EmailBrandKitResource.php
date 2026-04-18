<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailBrandKit;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Schemas\EmailBrandKitForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Schemas\EmailBrandKitInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Tables\EmailBrandKitsTable;

class EmailBrandKitResource extends Resource
{
    protected static ?string $model = EmailBrandKit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-mail-editor::filament-mail-editor.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_brand_kit.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_brand_kit.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_brand_kit.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return EmailBrandKitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmailBrandKitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailBrandKitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailBrandKits::route('/'),
            'create' => Pages\CreateEmailBrandKit::route('/create'),
            'view' => Pages\ViewEmailBrandKit::route('/{record}'),
            'edit' => Pages\EditEmailBrandKit::route('/{record}/edit'),
        ];
    }
}
