<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\TextInput;

/**
 * Renders hidden preheader text that appears in email client previews.
 *
 * The preheader is visually hidden in the email body but displayed as preview
 * text in inbox listings (Gmail, Outlook, Apple Mail). Uses display:none and
 * mso-hide:all for cross-client support. Recommended length: 30-90 characters.
 *
 * @see https://www.litmus.com/blog/the-ultimate-guide-to-preview-text-support
 * @see https://www.goodemailcode.com/email-code/preheader
 */
class PreheaderBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'preheader';
    }

    public static function label(): string
    {
        return 'Preheader';
    }

    public static function icon(): string
    {
        return 'heroicon-o-eye-slash';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'text' => '',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Preheader Text')
                ->maxLength(90)
                ->required(),
        ];
    }
}
