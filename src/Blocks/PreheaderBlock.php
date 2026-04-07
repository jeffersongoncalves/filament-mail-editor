<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\TextInput;

class PreheaderBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'preheader';
    }

    public static function label(): string
    {
        return 'Preheader';
    }

    public static function icon(): string
    {
        return 'heroicon-o-eye-slash';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'text' => '',
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Preheader Text')
                ->maxLength(90)
                ->required(),
        ];
    }
}
