<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\LogoGridBlock as BaseLogoGridBlock;

class LogoGridBlock extends BaseLogoGridBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            Repeater::make('logos')
                ->label(__('filament-mail-editor::filament-mail-editor.props.logos'))
                ->schema([
                    TextInput::make('src')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.src'))
                        ->required(),
                    TextInput::make('alt')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.alt')),
                    TextInput::make('link')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.link')),
                ])
                ->defaultItems(1)
                ->columnSpanFull(),
            Select::make('cols')
                ->label(__('filament-mail-editor::filament-mail-editor.props.columns'))
                ->options([
                    2 => '2 Columns',
                    3 => '3 Columns',
                    4 => '4 Columns',
                ])
                ->default(3),
            Toggle::make('grayscale')
                ->label(__('filament-mail-editor::filament-mail-editor.props.grayscale'))
                ->default(true),
            TextInput::make('cell_padding')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cell_padding'))
                ->numeric()
                ->suffix('px')
                ->default(16),
        ];
    }
}
