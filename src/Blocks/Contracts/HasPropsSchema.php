<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts;

/** Filament form for a block's props, layered on top of a jeffersongoncalves/laravel-mail-editor block. */
interface HasPropsSchema
{
    public static function propsSchema(): array;
}
