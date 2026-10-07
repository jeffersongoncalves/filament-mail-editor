<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\ButtonBlock as BaseButtonBlock;

class ButtonBlock extends BaseButtonBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text'))
                ->required(),
            TextInput::make('url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.url'))
                ->url()
                ->required(),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color')),
            TextInput::make('border_radius')
                ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                ->numeric()
                ->default(4),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->default('auto'),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->default(14),
            TextInput::make('padding')
                ->label(__('filament-mail-editor::filament-mail-editor.props.padding'))
                ->default('12px 28px'),
        ];
    }
}
