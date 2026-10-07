<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\ThreeColumnsBlock as BaseThreeColumnsBlock;

class ThreeColumnsBlock extends BaseThreeColumnsBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            RichEditor::make('col1_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.left_column'))
                ->columnSpanFull(),
            RichEditor::make('col2_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.center_column'))
                ->columnSpanFull(),
            RichEditor::make('col3_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.right_column'))
                ->columnSpanFull(),
            TextInput::make('gap')
                ->label(__('filament-mail-editor::filament-mail-editor.props.gap'))
                ->numeric()
                ->suffix('px')
                ->default(12),
            Toggle::make('stack_mobile')
                ->label(__('filament-mail-editor::filament-mail-editor.props.stack_on_mobile'))
                ->default(true),
        ];
    }
}
