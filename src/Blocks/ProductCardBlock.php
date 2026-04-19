<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

/**
 * Renders a product card with image, badge, pricing, and CTA button.
 *
 * Supports old/new price display with strikethrough, image badges (SALE, NEW),
 * and a VML-based CTA button for Outlook compatibility. The card layout uses
 * a bordered table container for consistent rendering.
 *
 * @see https://buttons.cm — Bulletproof Email Buttons for the CTA
 */
class ProductCardBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'product-card';
    }

    public static function label(): string
    {
        return 'Product Card';
    }

    public static function icon(): string
    {
        return 'heroicon-o-shopping-bag';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'image_src' => '',
            'image_alt' => '',
            'name' => '',
            'price' => '',
            'old_price' => '',
            'description' => '',
            'cta_text' => 'Buy Now',
            'cta_url' => '',
            'cta_bg_color' => '#378ADD',
            'badge_text' => '',
            'badge_bg_color' => '#e53e3e',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('image_src')
                ->label(__('filament-mail-editor::filament-mail-editor.props.image_src'))
                ->placeholder('https://...'),
            TextInput::make('image_alt')
                ->label(__('filament-mail-editor::filament-mail-editor.props.image_alt')),
            TextInput::make('name')
                ->label(__('filament-mail-editor::filament-mail-editor.props.name'))
                ->required(),
            TextInput::make('price')
                ->label(__('filament-mail-editor::filament-mail-editor.props.price'))
                ->required(),
            TextInput::make('old_price')
                ->label(__('filament-mail-editor::filament-mail-editor.props.old_price')),
            Textarea::make('description')
                ->label(__('filament-mail-editor::filament-mail-editor.props.description'))
                ->rows(2),
            TextInput::make('cta_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_text'))
                ->default('Buy Now'),
            TextInput::make('cta_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_url'))
                ->placeholder('https://...'),
            ColorPicker::make('cta_bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_bg_color'))
                ->default('#378ADD'),
            TextInput::make('badge_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.badge_text')),
            ColorPicker::make('badge_bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.badge_bg_color'))
                ->default('#e53e3e'),
        ];
    }
}
