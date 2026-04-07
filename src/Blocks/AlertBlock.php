<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

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
                ->label('Alert Type')
                ->options([
                    'info' => 'Info',
                    'warning' => 'Warning',
                    'error' => 'Error',
                    'success' => 'Success',
                ])
                ->default('info'),
            Textarea::make('text')
                ->label('Alert Text')
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            ColorPicker::make('bg_color')
                ->label('Background Color')
                ->placeholder('Auto'),
            ColorPicker::make('text_color')
                ->label('Text Color')
                ->placeholder('Auto'),
            ColorPicker::make('border_color')
                ->label('Border Color')
                ->placeholder('Auto'),
        ];
    }
}
