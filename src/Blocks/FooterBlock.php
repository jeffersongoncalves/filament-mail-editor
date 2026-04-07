<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class FooterBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'footer';
    }

    public static function label(): string
    {
        return 'Footer';
    }

    public static function icon(): string
    {
        return 'heroicon-o-bars-3-bottom-right';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'address' => '',
            'unsubscribe_url' => '',
            'unsubscribe_text' => 'Unsubscribe',
            'web_version_url' => null,
            'copyright' => null,
            'social_links' => [],
            'bg_color' => '#f8f9fa',
            'text_color' => '#999999',
            'font_size' => 11,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('address')
                ->label('Address')
                ->required(),
            TextInput::make('unsubscribe_url')
                ->label('Unsubscribe URL')
                ->url()
                ->required(),
            TextInput::make('unsubscribe_text')
                ->label('Unsubscribe Text')
                ->default('Unsubscribe'),
            TextInput::make('web_version_url')
                ->label('Web Version URL')
                ->url(),
            TextInput::make('copyright')
                ->label('Copyright'),
            Repeater::make('social_links')
                ->label('Social Links')
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->url()
                        ->required(),
                    TextInput::make('icon_src')
                        ->label('Icon URL')
                        ->url(),
                ])
                ->defaultItems(0)
                ->columnSpanFull(),
            ColorPicker::make('bg_color')
                ->label('Background Color'),
            ColorPicker::make('text_color')
                ->label('Text Color'),
            TextInput::make('font_size')
                ->label('Font Size')
                ->numeric()
                ->suffix('px')
                ->default(11),
        ];
    }
}
