<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TestimonialBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'testimonial';
    }

    public static function label(): string
    {
        return 'Testimonial';
    }

    public static function icon(): string
    {
        return 'heroicon-o-chat-bubble-bottom-center-text';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'quote' => '',
            'author' => '',
            'role' => '',
            'avatar_src' => null,
            'accent_color' => '#378ADD',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            Textarea::make('quote')
                ->label('Quote')
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            TextInput::make('author')
                ->label('Author')
                ->required(),
            TextInput::make('role')
                ->label('Role'),
            TextInput::make('avatar_src')
                ->label('Avatar URL')
                ->url(),
            ColorPicker::make('accent_color')
                ->label('Accent Color'),
        ];
    }
}
