<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a countdown timer as a server-generated image.
 *
 * Email clients do not support JavaScript or CSS animations, so the only
 * cross-client solution is a server-side generated image. This block renders
 * an <img> tag pointing to a route that generates a countdown image via GD.
 *
 * The image URL is absolute, using the configured app_url. When the countdown
 * expires, the route returns a static "expired" image instead.
 *
 * @see https://www.litmus.com/blog/countdown-timers-in-email
 * @see https://www.emailonacid.com/blog/article/email-development/countdown-timers-in-email/
 */
class CountdownBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'countdown';
    }

    public static function label(): string
    {
        return 'Countdown';
    }

    public static function icon(): string
    {
        return 'heroicon-o-clock';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'end_date' => null,
            'timezone' => 'America/Sao_Paulo',
            'label' => 'Offer ends in',
            'style' => 'default',
            'width' => 500,
            'height' => 80,
            'expired_text' => 'Offer expired',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            DateTimePicker::make('end_date')
                ->label(__('filament-mail-editor::filament-mail-editor.props.end_date'))
                ->seconds(false)
                ->required(),
            Select::make('timezone')
                ->label(__('filament-mail-editor::filament-mail-editor.props.timezone'))
                ->searchable()
                ->default('America/Sao_Paulo')
                ->options(array_combine(
                    timezone_identifiers_list(),
                    timezone_identifiers_list(),
                )),
            TextInput::make('label')
                ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                ->default('Offer ends in'),
            Select::make('style')
                ->label(__('filament-mail-editor::filament-mail-editor.props.style'))
                ->options([
                    'default' => 'Default',
                    'dark' => 'Dark',
                    'minimal' => 'Minimal',
                ])
                ->default('default'),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->numeric()
                ->suffix('px')
                ->minValue(200)
                ->maxValue(1200)
                ->default(500),
            TextInput::make('height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.height'))
                ->numeric()
                ->suffix('px')
                ->minValue(40)
                ->maxValue(400)
                ->default(80),
            TextInput::make('expired_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.expired_text'))
                ->default('Offer expired'),
        ];
    }
}
