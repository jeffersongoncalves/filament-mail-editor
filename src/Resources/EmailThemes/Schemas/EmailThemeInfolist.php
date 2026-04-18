<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Schemas;

use Filament\Infolists;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailThemeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.identification'))
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name')),
                        Infolists\Components\TextEntry::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->color('gray'),
                        Infolists\Components\IconEntry::make('is_default')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_default'))
                            ->boolean(),
                        Infolists\Components\IconEntry::make('is_system')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_system'))
                            ->boolean(),
                    ])->columns(4),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.colors'))
                    ->schema([
                        Infolists\Components\ColorEntry::make('colors.primary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.primary_color')),
                        Infolists\Components\ColorEntry::make('colors.secondary_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.secondary_color')),
                        Infolists\Components\ColorEntry::make('colors.accent_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.accent_color')),
                        Infolists\Components\ColorEntry::make('colors.bg_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.bg_color')),
                        Infolists\Components\ColorEntry::make('colors.content_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.content_bg')),
                        Infolists\Components\ColorEntry::make('colors.text_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.text_color')),
                        Infolists\Components\ColorEntry::make('colors.muted_color')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.muted_color')),
                        Infolists\Components\ColorEntry::make('colors.button_bg')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_bg')),
                        Infolists\Components\ColorEntry::make('colors.button_text')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.button_text')),
                    ])->columns(3),

                Section::make(__('filament-mail-editor::filament-mail-editor.sections.typography'))
                    ->schema([
                        Infolists\Components\TextEntry::make('typography.font_family')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_family')),
                        Infolists\Components\TextEntry::make('typography.font_size_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.font_size_base'))
                            ->suffix('px'),
                        Infolists\Components\TextEntry::make('typography.line_height_base')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.line_height_base')),
                        Infolists\Components\TextEntry::make('typography.border_radius')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                            ->suffix('px'),
                    ])->columns(2),
            ]);
    }
}
