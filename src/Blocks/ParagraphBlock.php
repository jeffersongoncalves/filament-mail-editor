<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders rich text content with configurable typography settings.
 *
 * Supports HTML content with inline formatting (bold, italic, links).
 * Line height, font size, and color are applied via inline styles
 * for consistent rendering across email clients.
 *
 * @see https://www.caniemail.com/features/css-line-height/
 */
class ParagraphBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'paragraph';
    }

    public static function label(): string
    {
        return 'Paragraph';
    }

    public static function icon(): string
    {
        return 'heroicon-o-bars-3-bottom-left';
    }

    public static function defaultProps(): array
    {
        return [
            'html' => '',
            'color' => '#555555',
            'font_size' => 14,
            'line_height' => 1.7,
            'align' => 'left',
        ];
    }

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
