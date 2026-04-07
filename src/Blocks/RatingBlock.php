<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

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
                ->label('Stars')
                ->options([
                    1 => '1 Star',
                    2 => '2 Stars',
                    3 => '3 Stars',
                    4 => '4 Stars',
                    5 => '5 Stars',
                ])
                ->default(5),
            Textarea::make('text')
                ->label('Review Text')
                ->rows(3),
            TextInput::make('author')
                ->label('Author'),
            ColorPicker::make('star_color')
                ->label('Star Color')
                ->default('#EF9F27'),
        ];
    }
}
