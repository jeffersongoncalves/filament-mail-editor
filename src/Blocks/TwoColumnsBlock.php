<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TwoColumnsBlock extends AbstractEmailBlock
{
    public function getMediaQueries(): string
    {
        return '@media only screen and (max-width: 600px) { .two-col-td { display: block !important; width: 100% !important; padding-left: 0 !important; padding-right: 0 !important; } }';
    }

    public static function type(): string
    {
        return 'two-columns';
    }

    public static function label(): string
    {
        return 'Two Columns';
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
            'left_content' => '',
            'right_content' => '',
            'ratio' => '50-50',
            'gap' => 16,
            'bg_color_left' => null,
            'bg_color_right' => null,
            'stack_mobile' => true,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            RichEditor::make('left_content')
                ->label('Left Column Content')
                ->columnSpanFull(),
            RichEditor::make('right_content')
                ->label('Right Column Content')
                ->columnSpanFull(),
            Select::make('ratio')
                ->label('Column Ratio')
                ->options([
                    '50-50' => '50 / 50',
                    '60-40' => '60 / 40',
                    '40-60' => '40 / 60',
                ])
                ->default('50-50'),
            TextInput::make('gap')
                ->label('Gap')
                ->numeric()
                ->suffix('px')
                ->default(16),
            ColorPicker::make('bg_color_left')
                ->label('Left Background Color'),
            ColorPicker::make('bg_color_right')
                ->label('Right Background Color'),
            Toggle::make('stack_mobile')
                ->label('Stack on Mobile')
                ->default(true),
        ];
    }
}
