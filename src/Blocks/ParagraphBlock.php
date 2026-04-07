<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

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
                ->label('Content')
                ->required()
                ->columnSpanFull(),
            ColorPicker::make('color')
                ->label('Text Color'),
            TextInput::make('font_size')
                ->label('Font Size')
                ->numeric()
                ->default(14),
            TextInput::make('line_height')
                ->label('Line Height')
                ->numeric()
                ->step(0.1)
                ->default(1.7),
            Select::make('align')
                ->label('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('left'),
        ];
    }
}
