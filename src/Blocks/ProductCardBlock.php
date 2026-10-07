<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\ProductCardBlock as BaseProductCardBlock;

class ProductCardBlock extends BaseProductCardBlock implements HasPropsSchema
{
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
