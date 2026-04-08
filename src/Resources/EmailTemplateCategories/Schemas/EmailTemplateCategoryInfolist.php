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
            ->components([
                Section::make('Category Details')
                    ->schema([
                        TextEntry::make('name')
                            ->weight('bold'),
                        TextEntry::make('slug')
                            ->copyable()
                            ->color('gray'),
                        TextEntry::make('parent.name')
                            ->label('Parent Category')
                            ->placeholder('None (top-level)'),
                        TextEntry::make('sort_order'),
                    ])->columns(2),

                Section::make('Appearance')
                    ->schema([
                        ColorEntry::make('color')
                            ->label('Color'),
                        TextEntry::make('icon')
                            ->placeholder('Not set'),
                        TextEntry::make('description')
                            ->placeholder('No description')
                            ->color('gray')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Usage')
                    ->schema([
                        TextEntry::make('templates_count')
                            ->label('Templates')
                            ->state(fn ($record): string => (string) $record->templates()->count()),
                        TextEntry::make('children_count')
                            ->label('Subcategories')
                            ->state(fn ($record): string => (string) $record->children()->count()),
                        TextEntry::make('full_path')
                            ->label('Full Path')
                            ->state(fn ($record): string => $record->getFullPath())
                            ->color('gray'),
                    ])->columns(3),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
