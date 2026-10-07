<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\HeadingBlock as BaseHeadingBlock;

class HeadingBlock extends BaseHeadingBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text'))
                ->required(),
            Select::make('level')
                ->label(__('filament-mail-editor::filament-mail-editor.props.level'))
                ->options([
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                ])
                ->default('h2'),
            ColorPicker::make('color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color')),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->placeholder('Auto'),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('left'),
            TextInput::make('font_family')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_family')),
        ];
    }
}
