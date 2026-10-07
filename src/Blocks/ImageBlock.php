<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\ImageBlock as BaseImageBlock;

class ImageBlock extends BaseImageBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('src')
                ->label(__('filament-mail-editor::filament-mail-editor.props.src'))
                ->url()
                ->required(),
            TextInput::make('alt')
                ->label(__('filament-mail-editor::filament-mail-editor.props.alt'))
                ->required(),
            TextInput::make('link')
                ->label(__('filament-mail-editor::filament-mail-editor.props.link'))
                ->url(),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->default('100%'),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
            TextInput::make('border_radius')
                ->label(__('filament-mail-editor::filament-mail-editor.fields.border_radius'))
                ->numeric()
                ->default(0),
        ];
    }
}
