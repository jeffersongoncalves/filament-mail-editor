<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

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
                ->label('Product Image URL')
                ->placeholder('https://...'),
            TextInput::make('image_alt')
                ->label('Image Alt Text'),
            TextInput::make('name')
                ->label('Product Name')
                ->required(),
            TextInput::make('price')
                ->label('Price')
                ->required(),
            TextInput::make('old_price')
                ->label('Old Price (strikethrough)'),
            Textarea::make('description')
                ->label('Description')
                ->rows(2),
            TextInput::make('cta_text')
                ->label('CTA Button Text')
                ->default('Buy Now'),
            TextInput::make('cta_url')
                ->label('CTA URL')
                ->placeholder('https://...'),
            ColorPicker::make('cta_bg_color')
                ->label('CTA Background Color')
                ->default('#378ADD'),
            TextInput::make('badge_text')
                ->label('Badge Text (optional)'),
            ColorPicker::make('badge_bg_color')
                ->label('Badge Background Color')
                ->default('#e53e3e'),
        ];
    }
}
