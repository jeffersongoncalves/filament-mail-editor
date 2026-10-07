<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Tables;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Actions\SetDefaultAction;
use JeffersonGoncalves\MailEditor\Models\EmailBrandKit;

class EmailBrandKitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                    ->searchable()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_default')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_default'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\ColorColumn::make('colors.primary_color')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.primary_color')),
                Tables\Columns\ColorColumn::make('colors.secondary_color')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.secondary_color')),
                Tables\Columns\TextColumn::make('social_links')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.social_links'))
                    ->state(fn (EmailBrandKit $record): string => count($record->social_links ?? []).' links')
                    ->sortable(false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.updated_at'))
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                SetDefaultAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
