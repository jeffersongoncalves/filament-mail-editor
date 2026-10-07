<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\DividerBlock as BaseDividerBlock;

class DividerBlock extends BaseDividerBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            ColorPicker::make('color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.color')),
            TextInput::make('thickness')
                ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                ->numeric()
                ->default(1),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->default('100%'),
            Select::make('style')
                ->label(__('filament-mail-editor::filament-mail-editor.props.style'))
                ->options([
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                ])
                ->default('solid'),
        ];
    }
}
