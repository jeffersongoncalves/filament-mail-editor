<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailTemplateCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.category_details'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->weight('bold'),
                        TextEntry::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->copyable()
                            ->color('gray'),
                        TextEntry::make('parent.name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.parent_category'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_parent')),
                        TextEntry::make('sort_order')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.sort_order')),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.appearance'))
                    ->schema([
                        ColorEntry::make('color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.color')),
                        TextEntry::make('icon')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.icon'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_set')),
                        TextEntry::make('description')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.description'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_description'))
                            ->color('gray')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.usage'))
                    ->schema([
                        TextEntry::make('templates_count')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.templates'))
                            ->state(fn ($record): string => (string) $record->templates()->count()),
                        TextEntry::make('children_count')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.subcategories'))
                            ->state(fn ($record): string => (string) $record->children()->count()),
                        TextEntry::make('full_path')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.full_path'))
                            ->state(fn ($record): string => $record->getFullPath())
                            ->color('gray'),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.timestamps'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.created_at'))
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.updated_at'))
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
