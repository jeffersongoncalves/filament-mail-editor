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
                ->label('Background Color'),
            TextInput::make('bg_image')
                ->label('Background Image URL')
                ->url(),
            TextInput::make('overlay_opacity')
                ->label('Overlay Opacity')
                ->numeric()
                ->minValue(0)
                ->maxValue(1)
                ->step(0.1),
            TextInput::make('title')
                ->label('Title')
                ->required(),
            TextInput::make('subtitle')
                ->label('Subtitle'),
            TextInput::make('cta_text')
                ->label('CTA Text'),
            TextInput::make('cta_url')
                ->label('CTA URL')
                ->url(),
            ColorPicker::make('cta_bg_color')
                ->label('CTA Background Color'),
            ColorPicker::make('cta_text_color')
                ->label('CTA Text Color'),
            Select::make('align')
                ->label('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
        ];
    }
}
