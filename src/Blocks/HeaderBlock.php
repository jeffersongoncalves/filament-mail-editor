<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\HeaderBlock as BaseHeaderBlock;

class HeaderBlock extends BaseHeaderBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('logo_src')
                ->label(__('filament-mail-editor::filament-mail-editor.props.logo_src'))
                ->url(),
            TextInput::make('logo_alt')
                ->label(__('filament-mail-editor::filament-mail-editor.props.logo_alt')),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            TextInput::make('web_link')
                ->label(__('filament-mail-editor::filament-mail-editor.props.web_link'))
                ->url(),
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
