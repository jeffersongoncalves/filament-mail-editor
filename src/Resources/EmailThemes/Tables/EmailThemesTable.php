<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Tables;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Actions\SetDefaultAction;

class EmailThemesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_default')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_default'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_system')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_system'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\ColorColumn::make('colors.primary_color')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.primary_color')),
                Tables\Columns\ColorColumn::make('colors.secondary_color')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.secondary_color')),
                Tables\Columns\ColorColumn::make('colors.accent_color')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.accent_color')),
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
