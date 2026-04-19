<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EmailBrandKitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.general'))
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
                        Forms\Components\Toggle::make('is_default')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_default'))
                            ->helperText(__('filament-mail-editor::filament-mail-editor.fields.only_one_default_brand_kit')),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.logo'))
                    ->schema([
                        Forms\Components\TextInput::make('logo_url')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.logo_url'))
                            ->url()
                            ->maxLength(2048),
                        Forms\Components\TextInput::make('logo_alt')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.logo_alt'))
                            ->maxLength(255),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.colors'))
                    ->schema([
                        Forms\Components\ColorPicker::make('colors.primary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.primary_color')),
                        Forms\Components\ColorPicker::make('colors.secondary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.secondary_color')),
                        Forms\Components\ColorPicker::make('colors.accent_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.accent_color')),
                        Forms\Components\ColorPicker::make('colors.bg_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.bg_color')),
                        Forms\Components\ColorPicker::make('colors.content_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.content_bg')),
                        Forms\Components\ColorPicker::make('colors.text_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.text_color')),
                        Forms\Components\ColorPicker::make('colors.muted_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.muted_color')),
                        Forms\Components\ColorPicker::make('colors.button_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_bg')),
                        Forms\Components\ColorPicker::make('colors.button_text')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_text')),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.typography'))
                    ->schema([
                        Forms\Components\TextInput::make('typography.font_family')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_family'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.font_family_placeholder')),
                        Forms\Components\TextInput::make('typography.font_size_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.base_font_size_px'))
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(32),
                        Forms\Components\TextInput::make('typography.line_height_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.line_height'))
                            ->numeric()
                            ->step(0.1)
                            ->minValue(1)
                            ->maxValue(3),
                        Forms\Components\TextInput::make('typography.border_radius')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius_px'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(50),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.social_links'))
                    ->schema([
                        Forms\Components\Repeater::make('social_links')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.social_links'))
                            ->hiddenLabel()
                            ->schema([
                                Forms\Components\Select::make('platform')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.platform'))
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'twitter' => 'Twitter / X',
                                        'instagram' => 'Instagram',
                                        'linkedin' => 'LinkedIn',
                                        'youtube' => 'YouTube',
                                        'tiktok' => 'TikTok',
                                        'github' => 'GitHub',
                                        'website' => 'Website',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('url')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.url'))
                                    ->url()
                                    ->required()
                                    ->maxLength(2048),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible(),
                    ]),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.footer'))
                    ->schema([
                        Forms\Components\Textarea::make('footer_address')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.company_address'))
                            ->rows(2)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('unsubscribe_url')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.unsubscribe_url'))
                            ->url()
                            ->maxLength(2048),
                    ])->columns(2),
            ]);
    }
}
