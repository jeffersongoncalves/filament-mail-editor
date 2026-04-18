<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
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
            TagsInput::make('headers')
                ->label('Headers')
                ->placeholder('Add column header')
                ->helperText('Press Enter after each header: Name, Price, Quantity')
                ->columnSpanFull(),
            Textarea::make('rows')
                ->label('Rows')
                ->rows(8)
                ->helperText('One row per line. Separate cells with pipes (|). E.g.: Product A | $10 | 5')
                ->columnSpanFull()
                ->formatStateUsing(static function (mixed $state): string {
                    if (! is_array($state)) {
                        return '';
                    }

                    return collect($state)
                        ->map(static fn ($row): string => is_array($row)
                            ? implode(' | ', array_map(static fn ($cell): string => (string) $cell, $row))
                            : (string) $row)
                        ->implode("\n");
                })
                ->dehydrateStateUsing(static function (mixed $state): array {
                    if (! is_string($state) || trim($state) === '') {
                        return [];
                    }

                    return collect(preg_split('/\r\n|\r|\n/', $state) ?: [])
                        ->map(static fn (string $line): string => trim($line))
                        ->filter()
                        ->map(static fn (string $line): array => array_map('trim', explode('|', $line)))
                        ->values()
                        ->all();
                }),
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
