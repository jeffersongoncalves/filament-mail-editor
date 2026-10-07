<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\TwoColumnsBlock as BaseTwoColumnsBlock;

class TwoColumnsBlock extends BaseTwoColumnsBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            RichEditor::make('left_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.left_column'))
                ->columnSpanFull(),
            RichEditor::make('right_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.right_column'))
                ->columnSpanFull(),
            Select::make('ratio')
                ->label(__('filament-mail-editor::filament-mail-editor.props.column_ratio'))
                ->options([
                    '50-50' => '50 / 50',
                    '60-40' => '60 / 40',
                    '40-60' => '40 / 60',
                ])
                ->default('50-50'),
            TextInput::make('gap')
                ->label(__('filament-mail-editor::filament-mail-editor.props.gap'))
                ->numeric()
                ->suffix('px')
                ->default(16),
            ColorPicker::make('bg_color_left')
                ->label(__('filament-mail-editor::filament-mail-editor.props.left_bg_color')),
            ColorPicker::make('bg_color_right')
                ->label(__('filament-mail-editor::filament-mail-editor.props.right_bg_color')),
            Toggle::make('stack_mobile')
                ->label(__('filament-mail-editor::filament-mail-editor.props.stack_on_mobile'))
                ->default(true),
        ];
    }
}
