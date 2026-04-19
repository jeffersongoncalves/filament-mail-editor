<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a large hero section with title, subtitle, CTA button, and optional background image.
 *
 * Uses VML (Vector Markup Language) for Outlook background image support,
 * since Outlook does not support CSS background-image on table cells.
 * Falls back to solid color on clients that don't support VML.
 *
 * @see https://backgrounds.cm — Bulletproof Email Backgrounds
 * @see https://www.campaignmonitor.com/blog/email-marketing/background-images-in-html-email/
 */
class HeroBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'hero';
    }

    public static function label(): string
    {
        return 'Hero';
    }

    public static function icon(): string
    {
        return 'heroicon-o-photo';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'bg_color' => '#185FA5',
            'bg_image' => null,
            'overlay_opacity' => 0.5,
            'title' => '',
            'subtitle' => '',
            'cta_text' => '',
            'cta_url' => '',
            'cta_bg_color' => '#ffffff',
            'cta_text_color' => '#185FA5',
            'align' => 'center',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            TextInput::make('bg_image')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_image'))
                ->url(),
            TextInput::make('overlay_opacity')
                ->label(__('filament-mail-editor::filament-mail-editor.props.overlay_opacity'))
                ->numeric()
                ->minValue(0)
                ->maxValue(1)
                ->step(0.1),
            TextInput::make('title')
                ->label(__('filament-mail-editor::filament-mail-editor.props.title'))
                ->required(),
            TextInput::make('subtitle')
                ->label(__('filament-mail-editor::filament-mail-editor.props.subtitle')),
            TextInput::make('cta_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_text')),
            TextInput::make('cta_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_url'))
                ->url(),
            ColorPicker::make('cta_bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_bg_color')),
            ColorPicker::make('cta_text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_text_color')),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
        ];
    }
}
