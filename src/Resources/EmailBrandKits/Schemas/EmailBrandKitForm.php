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
            ->columns(null)
            ->components([
                Section::make('General')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Toggle::make('is_default')
                            ->helperText('Only one brand kit can be the default.'),
                    ])->columns(2),

                Section::make('Logo')
                    ->schema([
                        Forms\Components\TextInput::make('logo_url')
                            ->label('Logo URL')
                            ->url()
                            ->maxLength(2048),
                        Forms\Components\TextInput::make('logo_alt')
                            ->label('Logo Alt Text')
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Colors')
                    ->schema([
                        Forms\Components\ColorPicker::make('colors.primary_color')
                            ->label('Primary Color'),
                        Forms\Components\ColorPicker::make('colors.secondary_color')
                            ->label('Secondary Color'),
                        Forms\Components\ColorPicker::make('colors.accent_color')
                            ->label('Accent Color'),
                        Forms\Components\ColorPicker::make('colors.bg_color')
                            ->label('Background Color'),
                        Forms\Components\ColorPicker::make('colors.content_bg')
                            ->label('Content Background'),
                        Forms\Components\ColorPicker::make('colors.text_color')
                            ->label('Text Color'),
                        Forms\Components\ColorPicker::make('colors.muted_color')
                            ->label('Muted Color'),
                        Forms\Components\ColorPicker::make('colors.button_bg')
                            ->label('Button Background'),
                        Forms\Components\ColorPicker::make('colors.button_text')
                            ->label('Button Text'),
                    ])->columns(3),

                Section::make('Typography')
                    ->schema([
                        Forms\Components\TextInput::make('typography.font_family')
                            ->label('Font Family')
                            ->placeholder('Arial, Helvetica, sans-serif'),
                        Forms\Components\TextInput::make('typography.font_size_base')
                            ->label('Base Font Size (px)')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(32),
                        Forms\Components\TextInput::make('typography.line_height_base')
                            ->label('Line Height')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(1)
                            ->maxValue(3),
                        Forms\Components\TextInput::make('typography.border_radius')
                            ->label('Border Radius (px)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(50),
                    ])->columns(2),

                Section::make('Social Links')
                    ->schema([
                        Forms\Components\Repeater::make('social_links')
                            ->schema([
                                Forms\Components\Select::make('platform')
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
                                    ->url()
                                    ->required()
                                    ->maxLength(2048),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible(),
                    ]),

                Section::make('Footer')
                    ->schema([
                        Forms\Components\Textarea::make('footer_address')
                            ->label('Company Address')
                            ->rows(2)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('unsubscribe_url')
                            ->label('Unsubscribe URL')
                            ->url()
                            ->maxLength(2048),
                    ])->columns(2),
            ]);
    }
}
