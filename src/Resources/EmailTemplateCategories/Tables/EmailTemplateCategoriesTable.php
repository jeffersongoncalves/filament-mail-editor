<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Tables;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\MailEditor\Models\EmailTemplateCategory;

class EmailTemplateCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->description(fn (EmailTemplateCategory $record): string => $record->getFullPath()),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                    ->searchable()
                    ->color('gray'),
                Tables\Columns\ColorColumn::make('color')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.color')),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.parent'))
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('templates_count')
                    ->label(__('filament-mail-editor::filament-mail-editor.resource.email_template.plural_model_label'))
                    ->state(fn (EmailTemplateCategory $record): string => (string) $record->templates()->count())
                    ->sortable(false),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.sort_order'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.updated_at'))
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.parent'))
                    ->relationship('parent', 'name')
                    ->placeholder('—'),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order');
    }
}
