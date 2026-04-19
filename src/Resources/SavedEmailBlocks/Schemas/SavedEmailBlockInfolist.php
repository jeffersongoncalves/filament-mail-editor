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
            ->columns(1)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.block_details'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->weight('bold'),
                        TextEntry::make('type')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.type'))
                            ->badge()
                            ->color('info'),
                        TextEntry::make('category')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'structure' => 'gray',
                                'content' => 'info',
                                'marketing' => 'success',
                                default => 'gray',
                            })
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_category')),
                        IconEntry::make('is_global')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_global'))
                            ->boolean(),
                    ])->columns(4),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.description'))
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.description'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_description'))
                            ->color('gray')
                            ->columnSpanFull(),
                        TextEntry::make('thumbnail')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.thumbnail_url'))
                            ->copyable()
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_thumbnail')),
                        TextEntry::make('user_id')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.owner'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.system_global')),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.properties'))
                    ->schema([
                        KeyValueEntry::make('props')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.props'))
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),

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
