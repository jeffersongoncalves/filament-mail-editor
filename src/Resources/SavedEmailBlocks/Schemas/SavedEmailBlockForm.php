<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\FilamentMailEditor\Enums\BlockCategory;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;

class SavedEmailBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
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
                            ->searchable(),
                        Forms\Components\Select::make('category')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                            ->options(BlockCategory::class),
                        Forms\Components\Toggle::make('is_global')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_global'))
                            ->default(true),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.fields.description'))
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
            ]);
    }
}
