<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

/**
 * Renders an HTML data table with headers and optional striped rows.
 *
 * Uses native HTML <table> with thead/tbody for structured data display.
 * Supports configurable header colors, striping, and border styles.
 * Ideal for order summaries, pricing tables, and comparison charts.
 */
class DataTableBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'data-table';
    }

    public static function label(): string
    {
        return 'Data Table';
    }

    public static function icon(): string
    {
        return 'heroicon-o-table-cells';
    }

    public static function category(): string
    {
        return 'content';
    }

    public static function defaultProps(): array
    {
        return [
            'headers' => [],
            'rows' => [],
            'striped' => true,
            'header_bg_color' => '#378ADD',
            'header_text_color' => '#ffffff',
            'stripe_color' => '#f8f9fa',
            'font_size' => 13,
            'border_color' => '#e8e8e8',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('headers_csv')
                ->label('Headers (comma-separated)')
                ->helperText('e.g.: Name, Price, Quantity'),
            TextInput::make('rows_csv')
                ->label('Rows (semicolon-separated rows, comma-separated cells)')
                ->helperText('e.g.: Product A, $10, 5; Product B, $20, 3'),
            Toggle::make('striped')
                ->label('Striped Rows')
                ->default(true),
            ColorPicker::make('header_bg_color')
                ->label('Header Background')
                ->default('#378ADD'),
            ColorPicker::make('header_text_color')
                ->label('Header Text Color')
                ->default('#ffffff'),
            ColorPicker::make('stripe_color')
                ->label('Stripe Color')
                ->default('#f8f9fa'),
            TextInput::make('font_size')
                ->label('Font Size')
                ->numeric()
                ->suffix('px')
                ->default(13),
            ColorPicker::make('border_color')
                ->label('Border Color')
                ->default('#e8e8e8'),
        ];
    }
}
