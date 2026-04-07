<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

/**
 * Renders a grid of logos with configurable columns and optional grayscale filter.
 *
 * Uses a table-based grid layout for cross-client compatibility. Each logo
 * can optionally link to a URL. The grayscale CSS filter works in modern
 * clients but is ignored in Outlook (logos appear in full color).
 *
 * @see https://www.caniemail.com/features/css-filter/
 */
class LogoGridBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'logo-grid';
    }

    public static function label(): string
    {
        return 'Logo Grid';
    }

    public static function icon(): string
    {
        return 'heroicon-o-squares-2x2';
    }

    public static function category(): string
    {
        return 'marketing';
    }

    public static function defaultProps(): array
    {
        return [
            'logos' => [],
            'cols' => 3,
            'grayscale' => true,
            'cell_padding' => 16,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            Repeater::make('logos')
                ->label('Logos')
                ->schema([
                    TextInput::make('src')
                        ->label('Image URL')
                        ->required(),
                    TextInput::make('alt')
                        ->label('Alt Text'),
                    TextInput::make('link')
                        ->label('Link URL'),
                ])
                ->defaultItems(1)
                ->columnSpanFull(),
            Select::make('cols')
                ->label('Columns')
                ->options([
                    2 => '2 Columns',
                    3 => '3 Columns',
                    4 => '4 Columns',
                ])
                ->default(3),
            Toggle::make('grayscale')
                ->label('Grayscale')
                ->default(true),
            TextInput::make('cell_padding')
                ->label('Cell Padding')
                ->numeric()
                ->suffix('px')
                ->default(16),
        ];
    }
}
