<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders the email header with logo and optional "view in browser" link.
 *
 * Provides a consistent top section with configurable background color,
 * logo image, and alignment. The logo uses max-width constraints for
 * responsive scaling on mobile clients.
 *
 * @see https://www.emailonacid.com/blog/article/email-development/email-header-best-practices/
 */
class HeaderBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'header';
    }

    public static function label(): string
    {
        return 'Header';
    }

    public static function icon(): string
    {
        return 'heroicon-o-bars-3';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'logo_src' => '',
            'logo_alt' => '',
            'bg_color' => '#1A3A5C',
            'web_link' => '',
            'align' => 'center',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('logo_src')
                ->label('Logo URL')
                ->url(),
            TextInput::make('logo_alt')
                ->label('Logo Alt Text'),
            ColorPicker::make('bg_color')
                ->label('Background Color'),
            TextInput::make('web_link')
                ->label('Web Version Link')
                ->url(),
            Select::make('align')
                ->label('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
        ];
    }
}
