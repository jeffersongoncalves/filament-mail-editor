<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\PreheaderBlock as BasePreheaderBlock;

class PreheaderBlock extends BasePreheaderBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.preview_text'))
                ->maxLength(90)
                ->required(),
        ];
    }
}
