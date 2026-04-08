<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;

class SavedEmailBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Block Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options(fn () => collect(app(BlockRegistry::class)->catalog())
                                ->mapWithKeys(fn (array $block): array => [$block['type'] => $block['label']]))
                            ->searchable(),
                        Forms\Components\Select::make('category')
                            ->options([
                                'structure' => 'Structure',
                                'content' => 'Content',
                                'marketing' => 'Marketing',
                            ]),
                        Forms\Components\Toggle::make('is_global')
                            ->default(true)
                            ->helperText('Global blocks are available to all users.'),
                    ])->columns(2),

                Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('thumbnail')
                            ->label('Thumbnail URL')
                            ->url()
                            ->maxLength(2048),
                    ])->columns(2),

                Section::make('Block Properties')
                    ->schema([
                        Forms\Components\KeyValue::make('props')
                            ->label('Properties (JSON)')
                            ->reorderable()
                            ->addActionLabel('Add Property'),
                    ]),
            ]);
    }
}
