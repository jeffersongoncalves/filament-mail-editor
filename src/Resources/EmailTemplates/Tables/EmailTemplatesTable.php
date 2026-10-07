<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Tables;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\DuplicateAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\ExportJsonAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\OpenBuilderAction;
use JeffersonGoncalves\FilamentMailEditor\Support\EnumPresenter;
use JeffersonGoncalves\MailEditor\Enums\TemplateCategory;
use JeffersonGoncalves\MailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class EmailTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.subject'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                EnumPresenter::badge(Tables\Columns\TextColumn::make('category'))
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('blocks_count')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.blocks_count'))
                    ->state(fn (EmailTemplate $record): string => count($record->blocks ?? []).' blocks')
                    ->sortable(false),
                EnumPresenter::badge(Tables\Columns\TextColumn::make('status'))
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.status'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_active'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.updated_at'))
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                    ->options(EnumPresenter::options(TemplateCategory::class)),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.status'))
                    ->options(EnumPresenter::options(TemplateStatus::class)),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_active')),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->recordActions([
                OpenBuilderAction::make()->iconButton()->tooltip(__('filament-mail-editor::filament-mail-editor.actions.open_builder')),
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                DuplicateAction::make(),
                ExportJsonAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                    Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
