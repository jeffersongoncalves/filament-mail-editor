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
                ->label(__('filament-mail-editor::filament-mail-editor.props.text'))
                ->required(),
            TextInput::make('url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.url'))
                ->url()
                ->required(),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color')),
            TextInput::make('border_radius')
                ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                ->numeric()
                ->default(4),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->default('auto'),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->default(14),
            TextInput::make('padding')
                ->label(__('filament-mail-editor::filament-mail-editor.props.padding'))
                ->default('12px 28px'),
        ];
    }
}
