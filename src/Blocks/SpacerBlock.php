<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\SpacerBlock as BaseSpacerBlock;

class SpacerBlock extends BaseSpacerBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.height'))
                ->numeric()
                ->suffix('px')
                ->default(24),
            TextInput::make('mobile_height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.mobile_height'))
                ->numeric()
                ->suffix('px')
                ->default(12),
        ];
    }
}
