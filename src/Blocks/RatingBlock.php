<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

/**
 * Renders a star rating display using Unicode characters.
 *
 * Uses Unicode filled star (U+2605) and empty star (U+2606) for maximum
 * email client compatibility without requiring images. Supports 1-5 stars
 * with configurable color and optional review text with author attribution.
 */
class RatingBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'rating';
    }

    public static function label(): string
    {
        return 'Rating';
    }

    public static function icon(): string
    {
        return 'heroicon-o-star';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'stars' => 5,
            'text' => '',
            'author' => '',
            'star_color' => '#EF9F27',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            Select::make('stars')
                ->label(__('filament-mail-editor::filament-mail-editor.props.rating'))
                ->options([
                    1 => '1 Star',
                    2 => '2 Stars',
                    3 => '3 Stars',
                    4 => '4 Stars',
                    5 => '5 Stars',
                ])
                ->default(5),
            Textarea::make('text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.review_text'))
                ->rows(3),
            TextInput::make('author')
                ->label(__('filament-mail-editor::filament-mail-editor.props.author')),
            ColorPicker::make('star_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.star_color'))
                ->default('#EF9F27'),
        ];
    }
}
