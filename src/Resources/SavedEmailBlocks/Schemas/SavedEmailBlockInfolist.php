<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas;

use Filament\Forms\Components\Field;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\View;
use Filament\Infolists\Infolist;
use JeffersonGoncalves\FilamentMailEditor\Enums\BlockCategory;
use JeffersonGoncalves\FilamentMailEditor\Models\SavedEmailBlock;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;

class SavedEmailBlockInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.preview'))
                    ->schema([
                        View::make('filament-mail-editor::resources.saved-email-blocks.preview'),
                    ])
                    ->collapsible(),

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
                            ->color(fn (BlockCategory|string|null $state): string => match ($state instanceof BlockCategory ? $state->value : $state) {
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
                    // Filament 3 infolists have no Get utility: read the type from the record
                    ->schema(fn (SavedEmailBlock $record): array => self::propsEntriesFor($record->type))
                    ->columns(2)
                    ->collapsible()
                    ->visible(fn (SavedEmailBlock $record): bool => filled($record->type)),

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

    /** @return array<int, TextEntry> */
    protected static function propsEntriesFor(mixed $type): array
    {
        if (! is_string($type) || $type === '') {
            return [];
        }

        $block = app(BlockRegistry::class)->find($type);
        if ($block === null) {
            return [];
        }

        $entries = [];
        foreach ($block::propsSchema() as $component) {
            if (! $component instanceof Field) {
                continue;
            }

            $name = $component->getName();
            $label = $component->getLabel();

            $entries[] = TextEntry::make("props.{$name}")
                ->label($label ?: $name)
                ->formatStateUsing(static function (mixed $state): string {
                    if ($state === null || $state === '') {
                        return '—';
                    }
                    if (is_bool($state)) {
                        return $state ? '✓' : '✗';
                    }
                    if (is_array($state)) {
                        return json_encode($state, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '—';
                    }

                    return (string) $state;
                })
                ->placeholder('—');
        }

        return $entries;
    }
}
