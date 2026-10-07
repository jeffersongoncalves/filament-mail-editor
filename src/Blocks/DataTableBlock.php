<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\DataTableBlock as BaseDataTableBlock;

class DataTableBlock extends BaseDataTableBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TagsInput::make('headers')
                ->label(__('filament-mail-editor::filament-mail-editor.props.headers'))
                ->placeholder('Add column header')
                ->helperText(__('filament-mail-editor::filament-mail-editor.props.headers_hint'))
                ->columnSpanFull(),
            Textarea::make('rows')
                ->label(__('filament-mail-editor::filament-mail-editor.props.rows'))
                ->rows(8)
                ->helperText(__('filament-mail-editor::filament-mail-editor.props.rows_hint'))
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
                ->label(__('filament-mail-editor::filament-mail-editor.props.striped'))
                ->default(true),
            ColorPicker::make('header_bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.header_bg_color'))
                ->default('#378ADD'),
            ColorPicker::make('header_text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.header_text_color'))
                ->default('#ffffff'),
            ColorPicker::make('stripe_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.stripe_color'))
                ->default('#f8f9fa'),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->suffix('px')
                ->default(13),
            ColorPicker::make('border_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.border_color'))
                ->default('#e8e8e8'),
        ];
    }
}
