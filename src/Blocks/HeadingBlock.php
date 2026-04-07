<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a heading element (H1-H4) with configurable font, color, and alignment.
 *
 * Uses inline styles exclusively for email client compatibility. Font family
 * falls back to web-safe fonts since custom web fonts have limited support.
 *
 * @see https://www.caniemail.com/features/css-font-family/
 */
class HeadingBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'heading';
    }

    public static function label(): string
    {
        return 'Heading';
    }

    public static function icon(): string
    {
        return 'heroicon-o-h1';
    }

    public static function defaultProps(): array
    {
        return [
            'text' => '',
            'level' => 'h2',
            'color' => '#1a1a1a',
            'font_size' => null,
            'align' => 'left',
            'font_family' => 'Arial, sans-serif',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Heading Text')
                ->required(),
            Select::make('level')
                ->label('Heading Level')
                ->options([
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                ])
                ->default('h2'),
            ColorPicker::make('color')
                ->label('Text Color'),
            TextInput::make('font_size')
                ->label('Font Size')
                ->numeric()
                ->placeholder('Auto'),
            Select::make('align')
                ->label('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('left'),
            TextInput::make('font_family')
                ->label('Font Family'),
        ];
    }
}
