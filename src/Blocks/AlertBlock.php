<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\AlertBlock as BaseAlertBlock;

class AlertBlock extends BaseAlertBlock implements HasPropsSchema
{
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
