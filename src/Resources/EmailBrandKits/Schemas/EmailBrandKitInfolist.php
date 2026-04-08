<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailBrandKitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General')
                    ->schema([
                        TextEntry::make('name')
                            ->weight('bold'),
                        TextEntry::make('slug')
                            ->copyable()
                            ->color('gray'),
                        IconEntry::make('is_default')
                            ->boolean(),
                    ])->columns(3),

                Section::make('Logo')
                    ->schema([
                        TextEntry::make('logo_url')
                            ->label('Logo URL')
                            ->copyable()
                            ->placeholder('Not set'),
                        TextEntry::make('logo_alt')
                            ->label('Alt Text')
                            ->placeholder('Not set')
                            ->color('gray'),
                    ])->columns(2),

                Section::make('Colors')
                    ->schema([
                        ColorEntry::make('colors.primary_color')
                            ->label('Primary'),
                        ColorEntry::make('colors.secondary_color')
                            ->label('Secondary'),
                        ColorEntry::make('colors.accent_color')
                            ->label('Accent'),
                        ColorEntry::make('colors.bg_color')
                            ->label('Background'),
                        ColorEntry::make('colors.content_bg')
                            ->label('Content BG'),
                        ColorEntry::make('colors.text_color')
                            ->label('Text'),
                        ColorEntry::make('colors.muted_color')
                            ->label('Muted'),
                        ColorEntry::make('colors.button_bg')
                            ->label('Button BG'),
                        ColorEntry::make('colors.button_text')
                            ->label('Button Text'),
                    ])->columns(3),

                Section::make('Typography')
                    ->schema([
                        TextEntry::make('typography.font_family')
                            ->label('Font Family')
                            ->placeholder('Default'),
                        TextEntry::make('typography.font_size_base')
                            ->label('Font Size')
                            ->suffix('px'),
                        TextEntry::make('typography.line_height_base')
                            ->label('Line Height'),
                        TextEntry::make('typography.border_radius')
                            ->label('Border Radius')
                            ->suffix('px'),
                    ])->columns(4),

                Section::make('Social Links')
                    ->schema([
                        RepeatableEntry::make('social_links')
                            ->label('')
                            ->schema([
                                TextEntry::make('platform')
                                    ->badge(),
                                TextEntry::make('url')
                                    ->copyable()
                                    ->color('primary'),
                            ])
                            ->columns(2),
                    ])
                    ->collapsible(),

                Section::make('Footer')
                    ->schema([
                        TextEntry::make('footer_address')
                            ->label('Company Address')
                            ->placeholder('Not set'),
                        TextEntry::make('unsubscribe_url')
                            ->label('Unsubscribe URL')
                            ->copyable()
                            ->placeholder('Not set'),
                    ])->columns(2),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
