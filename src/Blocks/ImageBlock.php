<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ImageBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'image';
    }

    public static function label(): string
    {
        return 'Image';
    }

    public static function icon(): string
    {
        return 'heroicon-o-photo';
    }

    public static function defaultProps(): array
    {
        return [
            'src' => '',
            'alt' => '',
            'link' => null,
            'width' => '100%',
            'align' => 'center',
            'border_radius' => 0,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            TextInput::make('src')
                ->label('Image URL')
                ->url()
                ->required(),
            TextInput::make('alt')
                ->label('Alt Text')
                ->required(),
            TextInput::make('link')
                ->label('Link URL')
                ->url(),
            TextInput::make('width')
                ->label('Width')
                ->default('100%'),
            Select::make('align')
                ->label('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
            TextInput::make('border_radius')
                ->label('Border Radius')
                ->numeric()
                ->default(0),
        ];
    }
}
