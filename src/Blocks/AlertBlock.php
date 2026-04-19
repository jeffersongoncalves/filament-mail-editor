<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

/**
 * Renders an alert/notification box with type-based color presets.
 *
 * Supports info, warning, error, and success types with automatic
 * color selection. Custom colors override the type defaults.
 * Uses a left border accent for visual distinction.
 */
class AlertBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'alert';
    }

    public static function label(): string
    {
        return 'Alert';
    }

    public static function icon(): string
    {
        return 'heroicon-o-exclamation-triangle';
    }

    public static function defaultProps(): array
    {
        return [
            'type' => 'info',
            'text' => '',
            'bg_color' => null,
            'text_color' => null,
            'border_color' => null,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            Select::make('type')
                ->label(__('filament-mail-editor::filament-mail-editor.props.type'))
                ->options([
                    'info' => 'Info',
                    'warning' => 'Warning',
                    'error' => 'Error',
                    'success' => 'Success',
                ])
                ->default('info'),
            Textarea::make('text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text'))
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color'))
                ->placeholder('Auto'),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color'))
                ->placeholder('Auto'),
            ColorPicker::make('border_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.border_color'))
                ->placeholder('Auto'),
        ];
    }
}
