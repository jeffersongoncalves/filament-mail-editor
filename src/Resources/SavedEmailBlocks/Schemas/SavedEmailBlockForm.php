<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use JeffersonGoncalves\FilamentMailEditor\Enums\BlockCategory;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;

class SavedEmailBlockForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.block'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.type'))
                            ->required()
                            ->options(fn () => collect(app(BlockRegistry::class)->catalog())
                                ->mapWithKeys(fn (array $block): array => [$block['type'] => $block['label']]))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (?string $state, ?string $old, Set $set): void {
                                if ($old === $state) {
                                    return;
                                }
                                $block = app(BlockRegistry::class)->find((string) $state);
                                $set('props', $block?->defaultProps() ?? []);
                            }),
                        Forms\Components\Select::make('category')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                            ->options(BlockCategory::class),
                        Forms\Components\Toggle::make('is_global')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_global'))
                            ->default(true),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.description'))
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.description'))
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('thumbnail')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.thumbnail'))
                            ->url()
                            ->maxLength(2048),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.properties'))
                    ->statePath('props')
                    ->schema(fn (Get $get): array => self::propsSchemaFor($get('type')))
                    ->columns(2)
                    ->visible(fn (Get $get): bool => filled($get('type'))),
            ]);
    }

    /** @return array<int, Component> */
    protected static function propsSchemaFor(mixed $type): array
    {
        if (! is_string($type) || $type === '') {
            return [];
        }

        $block = app(BlockRegistry::class)->find($type);

        if ($block === null) {
            return [];
        }

        return array_values(array_filter(
            $block::propsSchema(),
            static fn ($component): bool => $component instanceof Component,
        ));
    }
}
