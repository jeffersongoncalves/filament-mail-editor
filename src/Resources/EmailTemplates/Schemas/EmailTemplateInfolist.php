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
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.template_details'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->weight('bold'),
                        TextEntry::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->copyable()
                            ->color('gray'),
                        TextEntry::make('subject')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.subject')),
                        TextEntry::make('preheader')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.preheader'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_preheader'))
                            ->color('gray'),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.status_workflow'))
                    ->schema([
                        TextEntry::make('category')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                            ->badge(),
                        TextEntry::make('templateCategory.name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.template_category'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.none')),
                        IconEntry::make('is_active')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_active'))
                            ->boolean(),
                        TextEntry::make('status')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.status'))
                            ->badge(),
                        TextEntry::make('approved_by')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.approved_by'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_approved'))
                            ->color('gray'),
                        TextEntry::make('approved_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.approved_at'))
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('locked_by')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.locked_by'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_locked'))
                            ->color('gray'),
                        TextEntry::make('locked_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.locked_at'))
                            ->dateTime()
                            ->placeholder('—'),
                    ])->columns(4),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.content'))
                    ->schema([
                        TextEntry::make('blocks')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.blocks'))
                            ->state(fn ($record): string => __('filament-mail-editor::filament-mail-editor.fields.blocks_count_summary', ['count' => count($record->blocks ?? [])]))
                            ->icon('heroicon-o-cube'),
                        TextEntry::make('blocks_summary')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.blocks_summary'))
                            ->state(fn ($record): string => collect($record->blocks ?? [])
                                ->pluck('type')
                                ->countBy()
                                ->map(fn (int $count, string $type) => "{$type} ({$count})")
                                ->join(', '))
                            ->color('gray'),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.version_history'))
                    ->schema([
                        TextEntry::make('versions_count')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.total_versions'))
                            ->state(fn ($record): string => (string) $record->versions()->count()),
                        RepeatableEntry::make('versions')
                            ->label(__('filament-mail-editor::filament-mail-editor.sections.version_history'))
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('version_number')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.version'))
                                    ->prefix('#'),
                                TextEntry::make('reason')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.reason'))
                                    ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_reason'))
                                    ->color('gray'),
                                TextEntry::make('created_by')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.created_by'))
                                    ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.system'))
                                    ->color('gray'),
                                TextEntry::make('created_at')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.created_at'))
                                    ->dateTime(),
                            ])
                            ->columns(4),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.variants'))
                    ->schema([
                        TextEntry::make('variants_count')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.active_variants'))
                            ->state(fn ($record): string => (string) $record->variants()->count()),
                        RepeatableEntry::make('variants')
                            ->label(__('filament-mail-editor::filament-mail-editor.sections.variants'))
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.name')),
                                TextEntry::make('send_percentage')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.send_percentage'))
                                    ->suffix('%'),
                                IconEntry::make('is_winner')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.is_winner'))
                                    ->boolean(),
                            ])
                            ->columns(3),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.timestamps'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.created_at'))
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.updated_at'))
                            ->dateTime(),
                        TextEntry::make('deleted_at')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.deleted_at'))
                            ->dateTime()
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_deleted')),
                    ])->columns(3),
            ]);
    }
}
