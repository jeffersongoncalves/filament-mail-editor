<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SavedEmailBlockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Block Details')
                    ->schema([
                        TextEntry::make('name')
                            ->weight('bold'),
                        TextEntry::make('type')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('category')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'structure' => 'gray',
                                'content' => 'info',
                                'marketing' => 'success',
                                default => 'gray',
                            })
                            ->placeholder('No category'),
                        IconEntry::make('is_global')
                            ->boolean(),
                    ])->columns(4),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->placeholder('No description')
                            ->color('gray')
                            ->columnSpanFull(),
                        TextEntry::make('thumbnail')
                            ->label('Thumbnail URL')
                            ->copyable()
                            ->placeholder('No thumbnail'),
                        TextEntry::make('user_id')
                            ->label('Owner')
                            ->placeholder('System / Global'),
                    ])->columns(2),

                Section::make('Properties')
                    ->schema([
                        KeyValueEntry::make('props')
                            ->label(''),
                    ])
                    ->collapsible(),

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
