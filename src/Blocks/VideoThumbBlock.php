<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\VideoThumbBlock as BaseVideoThumbBlock;

class VideoThumbBlock extends BaseVideoThumbBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('thumb_src')
                ->label(__('filament-mail-editor::filament-mail-editor.props.thumb_src'))
                ->placeholder('https://...')
                ->required(),
            TextInput::make('video_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.video_url'))
                ->placeholder('https://youtube.com/...')
                ->required(),
            TextInput::make('alt')
                ->label(__('filament-mail-editor::filament-mail-editor.props.alt'))
                ->default('Watch video'),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->default('100%'),
            ColorPicker::make('play_icon_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.play_icon_color')),
        ];
    }
}
