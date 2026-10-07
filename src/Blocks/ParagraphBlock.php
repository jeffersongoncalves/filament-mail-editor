<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\ParagraphBlock as BaseParagraphBlock;

class ParagraphBlock extends BaseParagraphBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            RichEditor::make('html')
                ->label(__('filament-mail-editor::filament-mail-editor.props.html'))
                ->required()
                ->columnSpanFull(),
            ColorPicker::make('color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color')),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->default(14),
            TextInput::make('line_height')
                ->label(__('filament-mail-editor::filament-mail-editor.props.line_height'))
                ->numeric()
                ->step(0.1)
                ->default(1.7),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('left'),
        ];
    }
}
