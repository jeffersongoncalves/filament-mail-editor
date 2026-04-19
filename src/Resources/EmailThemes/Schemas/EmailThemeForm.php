<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTheme;

class EmailThemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.identification'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, ?string $old, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn (?EmailTheme $record): bool => (bool) $record?->is_system),
                        Forms\Components\Toggle::make('is_default')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_default')),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.colors'))
                    ->schema([
                        Forms\Components\ColorPicker::make('colors.primary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.primary_color'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.secondary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.secondary_color'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.accent_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.accent_color'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.bg_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.bg_color'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.content_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.content_bg'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.text_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.text_color'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.muted_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.muted_color'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.button_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_bg'))
                            ->required(),
                        Forms\Components\ColorPicker::make('colors.button_text')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_text'))
                            ->required(),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.typography'))
                    ->schema([
                        Forms\Components\TextInput::make('typography.font_family')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_family'))
                            ->required()
                            ->default('Arial, Helvetica, sans-serif')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('typography.font_size_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_size_base'))
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(24)
                            ->default(14)
                            ->suffix('px'),
                        Forms\Components\TextInput::make('typography.line_height_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.line_height_base'))
                            ->required()
                            ->numeric()
                            ->step(0.1)
                            ->minValue(1)
                            ->maxValue(3)
                            ->default(1.7),
                        Forms\Components\TextInput::make('typography.border_radius')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(32)
                            ->default(4)
                            ->suffix('px'),
                    ])->columns(2),
            ]);
    }
}
