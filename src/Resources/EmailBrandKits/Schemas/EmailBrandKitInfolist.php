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
            ->columns(1)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.general'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->weight('bold'),
                        TextEntry::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->copyable()
                            ->color('gray'),
                        IconEntry::make('is_default')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_default'))
                            ->boolean(),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.logo'))
                    ->schema([
                        TextEntry::make('logo_url')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.logo_url'))
                            ->copyable()
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_set')),
                        TextEntry::make('logo_alt')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.logo_alt'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_set'))
                            ->color('gray'),
                    ])->columns(2),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.colors'))
                    ->schema([
                        ColorEntry::make('colors.primary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.primary_color')),
                        ColorEntry::make('colors.secondary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.secondary_color')),
                        ColorEntry::make('colors.accent_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.accent_color')),
                        ColorEntry::make('colors.bg_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.bg_color')),
                        ColorEntry::make('colors.content_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.content_bg')),
                        ColorEntry::make('colors.text_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.text_color')),
                        ColorEntry::make('colors.muted_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.muted_color')),
                        ColorEntry::make('colors.button_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_bg')),
                        ColorEntry::make('colors.button_text')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_text')),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.typography'))
                    ->schema([
                        TextEntry::make('typography.font_family')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_family'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_set')),
                        TextEntry::make('typography.font_size_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_size_base'))
                            ->suffix('px'),
                        TextEntry::make('typography.line_height_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.line_height_base')),
                        TextEntry::make('typography.border_radius')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                            ->suffix('px'),
                    ])->columns(4),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.social_links'))
                    ->schema([
                        RepeatableEntry::make('social_links')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.social_links'))
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('platform')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.platform'))
                                    ->badge(),
                                TextEntry::make('url')
                                    ->label(__('filament-mail-editor::filament-mail-editor.fields.url'))
                                    ->copyable()
                                    ->color('primary'),
                            ])
                            ->columns(2),
                    ])
                    ->collapsible(),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.footer'))
                    ->schema([
                        TextEntry::make('footer_address')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.company_address'))
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_set')),
                        TextEntry::make('unsubscribe_url')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.unsubscribe_url'))
                            ->copyable()
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.not_set')),
                    ])->columns(2),

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
}
