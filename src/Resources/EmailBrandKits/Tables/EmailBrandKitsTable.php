<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Tables;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailBrandKit;

class EmailBrandKitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\ColorColumn::make('colors.primary_color')
                    ->label('Primary'),
                Tables\Columns\ColorColumn::make('colors.secondary_color')
                    ->label('Secondary'),
                Tables\Columns\TextColumn::make('social_links')
                    ->label('Social')
                    ->state(fn (EmailBrandKit $record): string => count($record->social_links ?? []).' links')
                    ->sortable(false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('setDefault')
                    ->icon('heroicon-m-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (EmailBrandKit $record): bool => ! $record->is_default)
                    ->action(fn (EmailBrandKit $record) => $record->setAsDefault()),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
