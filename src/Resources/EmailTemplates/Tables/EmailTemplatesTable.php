<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Tables;

use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateCategory;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;
use JeffersonGoncalves\FilamentMailEditor\Support\TemplateImportExport;

class EmailTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('blocks_count')
                    ->label('Blocks')
                    ->state(fn (EmailTemplate $record): string => count($record->blocks ?? []).' blocks')
                    ->sortable(false),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(TemplateCategory::class),
                Tables\Filters\SelectFilter::make('status')
                    ->options(TemplateStatus::class),
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('duplicate')
                    ->icon('heroicon-m-document-duplicate')
                    ->requiresConfirmation()
                    ->action(function (EmailTemplate $record) {
                        $clone = $record->replicate();
                        $clone->name = $clone->name.' (copy)';
                        $clone->slug = Str::slug($clone->name).'-'.time();
                        $clone->save();

                        return redirect(EmailTemplateResource::getUrl('edit', ['record' => $clone]));
                    }),
                Actions\Action::make('exportJson')
                    ->label('Export JSON')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->action(function (EmailTemplate $record) {
                        $json = (new TemplateImportExport)->exportJson($record);

                        return response()->streamDownload(
                            fn () => print ($json),
                            Str::slug($record->name).'.json',
                            ['Content-Type' => 'application/json']
                        );
                    }),
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
