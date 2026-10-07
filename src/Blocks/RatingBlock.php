<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\RatingBlock as BaseRatingBlock;

class RatingBlock extends BaseRatingBlock implements HasPropsSchema
{
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
