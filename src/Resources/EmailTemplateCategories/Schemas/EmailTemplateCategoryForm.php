<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EmailTemplateCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.category_details'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('parent_id')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.parent_category'))
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.no_parent')),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.sort_order'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.appearance'))
                    ->schema([
                        Forms\Components\ColorPicker::make('color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.color')),
                        Forms\Components\TextInput::make('icon')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.icon'))
                            ->placeholder('heroicon-o-folder')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.description'))
                            ->rows(3)
                            ->maxLength(500),
                    ])->columns(2),
            ]);
    }
}
