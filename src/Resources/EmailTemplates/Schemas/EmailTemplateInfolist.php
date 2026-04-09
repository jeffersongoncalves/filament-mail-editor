<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailTemplateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Template Details')
                    ->schema([
                        TextEntry::make('name')
                            ->weight('bold'),
                        TextEntry::make('slug')
                            ->copyable()
                            ->color('gray'),
                        TextEntry::make('subject'),
                        TextEntry::make('preheader')
                            ->placeholder('No preheader set')
                            ->color('gray'),
                    ])->columns(2),

                Section::make('Status & Workflow')
                    ->schema([
                        TextEntry::make('category')
                            ->badge(),
                        TextEntry::make('templateCategory.name')
                            ->label('Category Folder')
                            ->placeholder('None'),
                        IconEntry::make('is_active')
                            ->boolean(),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('approved_by')
                            ->placeholder('Not approved yet')
                            ->color('gray'),
                        TextEntry::make('approved_at')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('locked_by')
                            ->placeholder('Not locked')
                            ->color('gray'),
                        TextEntry::make('locked_at')
                            ->dateTime()
                            ->placeholder('—'),
                    ])->columns(4),

                Section::make('Content')
                    ->schema([
                        TextEntry::make('blocks')
                            ->label('Blocks')
                            ->state(fn ($record): string => count($record->blocks ?? []).' block(s)')
                            ->icon('heroicon-o-cube'),
                        TextEntry::make('blocks_summary')
                            ->label('Block Types')
                            ->state(fn ($record): string => collect($record->blocks ?? [])
                                ->pluck('type')
                                ->countBy()
                                ->map(fn (int $count, string $type) => "{$type} ({$count})")
                                ->join(', '))
                            ->color('gray'),
                    ])->columns(2),

                Section::make('Version History')
                    ->schema([
                        TextEntry::make('versions_count')
                            ->label('Total Versions')
                            ->state(fn ($record): string => (string) $record->versions()->count()),
                        RepeatableEntry::make('versions')
                            ->label('')
                            ->schema([
                                TextEntry::make('version_number')
                                    ->label('Version')
                                    ->prefix('#'),
                                TextEntry::make('reason')
                                    ->placeholder('No reason')
                                    ->color('gray'),
                                TextEntry::make('created_by')
                                    ->placeholder('System')
                                    ->color('gray'),
                                TextEntry::make('created_at')
                                    ->dateTime(),
                            ])
                            ->columns(4),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Variants (A/B Testing)')
                    ->schema([
                        TextEntry::make('variants_count')
                            ->label('Active Variants')
                            ->state(fn ($record): string => (string) $record->variants()->count()),
                        RepeatableEntry::make('variants')
                            ->label('')
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('send_percentage')
                                    ->suffix('%'),
                                IconEntry::make('is_winner')
                                    ->boolean(),
                            ])
                            ->columns(3),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->placeholder('Not deleted'),
                    ])->columns(3),
            ]);
    }
}
