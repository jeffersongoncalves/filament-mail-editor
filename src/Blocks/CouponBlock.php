<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a coupon/promo code block with a dashed border and monospace code.
 *
 * Uses Courier New monospace font for the code display to visually distinguish
 * it from regular text. Supports configurable border style (dashed/solid),
 * discount text, and expiration message.
 */
class CouponBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'coupon';
    }

    public static function label(): string
    {
        return 'Coupon';
    }

    public static function icon(): string
    {
        return 'heroicon-o-ticket';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'code' => '',
            'discount_text' => '',
            'expires_text' => '',
            'bg_color' => '#fff3cd',
            'border_color' => '#EF9F27',
            'border_style' => 'dashed',
            'text_color' => '#333333',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('code')
                ->label(__('filament-mail-editor::filament-mail-editor.props.code'))
                ->required(),
            TextInput::make('discount_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.discount'))
                ->placeholder('20% OFF'),
            TextInput::make('expires_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.expires'))
                ->placeholder('Valid until Dec 31'),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color'))
                ->default('#fff3cd'),
            ColorPicker::make('border_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.border_color'))
                ->default('#EF9F27'),
            Select::make('border_style')
                ->label(__('filament-mail-editor::filament-mail-editor.props.border_style'))
                ->options([
                    'dashed' => 'Dashed',
                    'solid' => 'Solid',
                ])
                ->default('dashed'),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color'))
                ->default('#333333'),
        ];
    }
}
