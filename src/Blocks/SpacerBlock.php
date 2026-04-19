<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\TextInput;

/**
 * Renders vertical spacing between blocks with separate desktop and mobile heights.
 *
 * Uses a table cell with explicit height for consistent rendering. Mobile height
 * is applied via media query to reduce excessive spacing on small screens.
 *
 * @see https://www.emailonacid.com/blog/article/email-development/spacing-in-html-email/
 */
class SpacerBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'spacer';
    }

    public static function label(): string
    {
        return 'Spacer';
    }

    public static function icon(): string
    {
        return 'heroicon-o-arrows-up-down';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'height' => 24,
            'mobile_height' => 12,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.height'))
                ->numeric()
                ->suffix('px')
                ->default(24),
            TextInput::make('mobile_height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.mobile_height'))
                ->numeric()
                ->suffix('px')
                ->default(12),
        ];
    }
}
