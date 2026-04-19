<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

/**
 * Renders the email footer with address, unsubscribe link, and copyright.
 *
 * The unsubscribe link is legally required in marketing emails (CAN-SPAM, LGPD, GDPR).
 * Footer includes optional social links and "view in browser" URL.
 * Uses small font size and muted colors per email design conventions.
 *
 * @see https://www.ftc.gov/business-guidance/resources/can-spam-act-compliance-guide-business
 */
class FooterBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'footer';
    }

    public static function label(): string
    {
        return 'Footer';
    }

    public static function icon(): string
    {
        return 'heroicon-o-bars-3-bottom-right';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'address' => '',
            'unsubscribe_url' => '',
            'unsubscribe_text' => 'Unsubscribe',
            'web_version_url' => null,
            'copyright' => null,
            'social_links' => [],
            'bg_color' => '#f8f9fa',
            'text_color' => '#999999',
            'font_size' => 11,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('address')
                ->label(__('filament-mail-editor::filament-mail-editor.props.address'))
                ->required(),
            TextInput::make('unsubscribe_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.unsubscribe_url'))
                ->url()
                ->required(),
            TextInput::make('unsubscribe_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.unsubscribe_text'))
                ->default('Unsubscribe'),
            TextInput::make('web_version_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.web_version_url'))
                ->url(),
            TextInput::make('copyright')
                ->label(__('filament-mail-editor::filament-mail-editor.props.copyright')),
            Repeater::make('social_links')
                ->label(__('filament-mail-editor::filament-mail-editor.sections.social_links'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.name'))
                        ->required(),
                    TextInput::make('url')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.url'))
                        ->url()
                        ->required(),
                    TextInput::make('icon_src')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.logo_src'))
                        ->url(),
                ])
                ->defaultItems(0)
                ->columnSpanFull(),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color')),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->suffix('px')
                ->default(11),
        ];
    }
}
