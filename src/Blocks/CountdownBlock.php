<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\CountdownBlock as BaseCountdownBlock;

class CountdownBlock extends BaseCountdownBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            DateTimePicker::make('end_date')
                ->label(__('filament-mail-editor::filament-mail-editor.props.end_date'))
                ->seconds(false)
                ->required(),
            Select::make('timezone')
                ->label(__('filament-mail-editor::filament-mail-editor.props.timezone'))
                ->searchable()
                ->default('America/Sao_Paulo')
                ->options(array_combine(
                    timezone_identifiers_list(),
                    timezone_identifiers_list(),
                )),
            TextInput::make('label')
                ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                ->default('Offer ends in'),
            Select::make('style')
                ->label(__('filament-mail-editor::filament-mail-editor.props.style'))
                ->options([
                    'default' => 'Default',
                    'dark' => 'Dark',
                    'minimal' => 'Minimal',
                ])
                ->default('default'),
            TextInput::make('width')
                ->label(__('filament-mail-editor::filament-mail-editor.props.width'))
                ->numeric()
                ->suffix('px')
                ->minValue(200)
                ->maxValue(1200)
                ->default(500),
            TextInput::make('height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.height'))
                ->numeric()
                ->suffix('px')
                ->minValue(40)
                ->maxValue(400)
                ->default(80),
            TextInput::make('expired_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.expired_text'))
                ->default('Offer expired'),
        ];
    }
}
