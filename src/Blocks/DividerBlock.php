<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a horizontal divider line with configurable color, thickness, and style.
 *
 * Uses a table-based approach instead of <hr> for consistent cross-client rendering.
 * Supports solid, dashed, and dotted border styles.
 *
 * @see https://www.emailonacid.com/blog/article/email-development/horizontal-rules-in-html-email/
 */
class DividerBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'divider';
    }

    public static function label(): string
    {
        return 'Divider';
    }

    public static function icon(): string
    {
        return 'heroicon-o-minus';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'color' => '#e8e8e8',
            'thickness' => 1,
            'width' => '100%',
            'style' => 'solid',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            ColorPicker::make('color')
                ->label('Color'),
            TextInput::make('thickness')
                ->label('Thickness')
                ->numeric()
                ->default(1),
            TextInput::make('width')
                ->label('Width')
                ->default('100%'),
            Select::make('style')
                ->label('Style')
                ->options([
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                ])
                ->default('solid'),
        ];
    }
}
