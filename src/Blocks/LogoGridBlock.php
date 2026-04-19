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
                ->label(__('filament-mail-editor::filament-mail-editor.props.logos'))
                ->schema([
                    TextInput::make('src')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.src'))
                        ->required(),
                    TextInput::make('alt')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.alt')),
                    TextInput::make('link')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.link')),
                ])
                ->defaultItems(1)
                ->columnSpanFull(),
            Select::make('cols')
                ->label(__('filament-mail-editor::filament-mail-editor.props.columns'))
                ->options([
                    2 => '2 Columns',
                    3 => '3 Columns',
                    4 => '4 Columns',
                ])
                ->default(3),
            Toggle::make('grayscale')
                ->label(__('filament-mail-editor::filament-mail-editor.props.grayscale'))
                ->default(true),
            TextInput::make('cell_padding')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cell_padding'))
                ->numeric()
                ->suffix('px')
                ->default(16),
        ];
    }
}
