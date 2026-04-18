<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Models\SavedEmailBlock;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas\SavedEmailBlockForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas\SavedEmailBlockInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Tables\SavedEmailBlocksTable;

class SavedEmailBlockResource extends Resource
{
    protected static ?string $model = SavedEmailBlock::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-mail-editor.navigation_group'));
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.saved_email_block.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.saved_email_block.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.saved_email_block.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return SavedEmailBlockForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SavedEmailBlockInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SavedEmailBlocksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSavedEmailBlocks::route('/'),
            'create' => Pages\CreateSavedEmailBlock::route('/create'),
            'view' => Pages\ViewSavedEmailBlock::route('/{record}'),
            'edit' => Pages\EditSavedEmailBlock::route('/{record}/edit'),
        ];
    }
}
