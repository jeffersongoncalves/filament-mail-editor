<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a bulletproof CTA button compatible with all major email clients.
 *
 * Uses VML for Outlook (2013-2021) and a standard <a> tag with padding for
 * others. The VML wrapping ensures Outlook renders rounded corners correctly.
 * Supports configurable colors, border radius, alignment, and full-width mode.
 *
 * @see https://buttons.cm — Bulletproof Email Buttons reference
 * @see https://www.campaignmonitor.com/blog/email-marketing/using-vml-ms-only-css-outlook/
 */
class ButtonBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'button';
    }

    public static function label(): string
    {
        return 'Button';
    }

    public static function icon(): string
    {
        return 'heroicon-o-cursor-arrow-rays';
    }

    public static function defaultProps(): array
    {
        return [
            'text' => '',
            'url' => '',
            'bg_color' => '#378ADD',
            'text_color' => '#ffffff',
            'border_radius' => 4,
            'align' => 'center',
            'width' => 'auto',
            'font_size' => 14,
            'padding' => '12px 28px',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Button Text')
                ->required(),
            TextInput::make('url')
                ->label('URL')
                ->url()
                ->required(),
            ColorPicker::make('bg_color')
                ->label('Background Color'),
            ColorPicker::make('text_color')
                ->label('Text Color'),
            TextInput::make('border_radius')
                ->label('Border Radius')
                ->numeric()
                ->default(4),
            Select::make('align')
                ->label('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
            TextInput::make('width')
                ->label('Width')
                ->default('auto'),
            TextInput::make('font_size')
                ->label('Font Size')
                ->numeric()
                ->default(14),
            TextInput::make('padding')
                ->label('Padding')
                ->default('12px 28px'),
        ];
    }
}
