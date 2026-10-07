<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Tables;

use Filament\Tables;
use Filament\Tables\Actions;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Support\EnumPresenter;
use JeffersonGoncalves\MailEditor\Enums\BlockCategory;
use JeffersonGoncalves\MailEditor\Models\SavedEmailBlock;

class SavedEmailBlocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.type'))
                    ->badge()
                    ->color('info')
                    ->sortable(),
                EnumPresenter::badge(Tables\Columns\TextColumn::make('category'))
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_global')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_global'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.updated_at'))
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.type'))
                    ->options(fn () => SavedEmailBlock::query()
                        ->distinct()
                        ->pluck('type', 'type')
                        ->toArray()),
                Tables\Filters\SelectFilter::make('category')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                    ->options(EnumPresenter::options(BlockCategory::class)),
                Tables\Filters\TernaryFilter::make('is_global')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_global')),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
