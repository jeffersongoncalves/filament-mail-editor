<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;

/**
 * Renders a video thumbnail image that links to the video URL.
 *
 * Email clients do not support embedded video (<video> tag). This block
 * displays a thumbnail with a play icon overlay that links to the video
 * URL (YouTube, Vimeo, etc.). Falls back to a gray placeholder with a
 * centered play triangle when no thumbnail is provided.
 *
 * @see https://www.emailonacid.com/blog/article/email-development/video-in-email/
 */
class VideoThumbBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'video-thumb';
    }

    public static function label(): string
    {
        return 'Video Thumbnail';
    }

    public static function icon(): string
    {
        return 'heroicon-o-play-circle';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'thumb_src' => '',
            'video_url' => '',
            'alt' => 'Watch video',
            'width' => '100%',
            'play_icon_color' => 'rgba(255,255,255,0.9)',
        ];
    }

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
