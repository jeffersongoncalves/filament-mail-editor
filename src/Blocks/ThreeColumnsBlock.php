<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ThreeColumnsBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'three-columns';
    }

    public static function label(): string
    {
        return 'Three Columns';
    }

    public static function icon(): string
    {
        return 'heroicon-o-view-columns';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'col1_content' => '',
            'col2_content' => '',
            'col3_content' => '',
            'gap' => 12,
            'stack_mobile' => true,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            RichEditor::make('col1_content')
                ->label('Column 1 Content')
                ->columnSpanFull(),
            RichEditor::make('col2_content')
                ->label('Column 2 Content')
                ->columnSpanFull(),
            RichEditor::make('col3_content')
                ->label('Column 3 Content')
                ->columnSpanFull(),
            TextInput::make('gap')
                ->label('Gap')
                ->numeric()
                ->suffix('px')
                ->default(12),
            Toggle::make('stack_mobile')
                ->label('Stack on Mobile')
                ->default(true),
        ];
    }

    public function getMediaQueries(): string
    {
        return '@media only screen and (max-width: 600px) { .three-col-td { display: block !important; width: 100% !important; padding-left: 0 !important; padding-right: 0 !important; } }';
    }
}
