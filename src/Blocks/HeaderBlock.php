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
                ->label(__('filament-mail-editor::filament-mail-editor.props.logo_src'))
                ->url(),
            TextInput::make('logo_alt')
                ->label(__('filament-mail-editor::filament-mail-editor.props.logo_alt')),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            TextInput::make('web_link')
                ->label(__('filament-mail-editor::filament-mail-editor.props.web_link'))
                ->url(),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
        ];
    }
}
