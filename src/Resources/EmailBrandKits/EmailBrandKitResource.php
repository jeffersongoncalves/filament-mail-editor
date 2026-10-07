<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Schemas\EmailBrandKitForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Schemas\EmailBrandKitInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Tables\EmailBrandKitsTable;
use JeffersonGoncalves\MailEditor\Models\EmailBrandKit;

class EmailBrandKitResource extends Resource
{
    protected static ?string $model = EmailBrandKit::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

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

    public static function form(Form $form): Form
    {
        return EmailBrandKitForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return EmailBrandKitInfolist::configure($infolist);
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
