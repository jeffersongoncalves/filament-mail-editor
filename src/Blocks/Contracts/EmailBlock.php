<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts;

interface EmailBlock
{
    public static function type(): string;

    public static function label(): string;

    public static function icon(): string;

    public static function category(): string;

    public static function defaultProps(): array;

    public static function propsSchema(): array;

    public function render(array $props): string;
}
