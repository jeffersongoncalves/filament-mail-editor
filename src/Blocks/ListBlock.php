<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\ListBlock as BaseListBlock;

class ListBlock extends BaseListBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            Repeater::make('items')
                ->label(__('filament-mail-editor::filament-mail-editor.props.items'))
                ->schema([
                    TextInput::make('text')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.text'))
                        ->required(),
                    TextInput::make('link')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.link'))
                        ->url(),
                ])
                ->defaultItems(1)
                ->columnSpanFull(),
            Select::make('type')
                ->label(__('filament-mail-editor::filament-mail-editor.props.type'))
                ->options([
                    'unordered' => 'Unordered',
                    'ordered' => 'Ordered',
                ])
                ->default('unordered'),
            TextInput::make('bullet_char')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bullet_char'))
                ->default("\u{2022}"),
            ColorPicker::make('bullet_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bullet_color'))
                ->default('#378ADD'),
            TextInput::make('indent')
                ->label(__('filament-mail-editor::filament-mail-editor.props.indent'))
                ->numeric()
                ->suffix('px')
                ->default(0),
            ColorPicker::make('color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color'))
                ->default('#333333'),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->suffix('px')
                ->default(14),
        ];
    }
}
