<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\EmailBlock;

abstract class AbstractEmailBlock implements EmailBlock
{
    public static function category(): string
    {
        return 'content';
    }

    public function render(array $props): string
    {
        $merged = array_merge(static::defaultProps(), $props);

        return view('filament-mail-editor::blocks.'.static::type(), ['props' => $merged])->render();
    }

    public function getMediaQueries(): string
    {
        return '';
    }
}
