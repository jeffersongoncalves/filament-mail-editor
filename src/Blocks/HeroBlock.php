<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\HeroBlock as BaseHeroBlock;

class HeroBlock extends BaseHeroBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            TextInput::make('bg_image')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_image'))
                ->url(),
            TextInput::make('overlay_opacity')
                ->label(__('filament-mail-editor::filament-mail-editor.props.overlay_opacity'))
                ->numeric()
                ->minValue(0)
                ->maxValue(1)
                ->step(0.1),
            TextInput::make('title')
                ->label(__('filament-mail-editor::filament-mail-editor.props.title'))
                ->required(),
            TextInput::make('subtitle')
                ->label(__('filament-mail-editor::filament-mail-editor.props.subtitle')),
            TextInput::make('cta_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_text')),
            TextInput::make('cta_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_url'))
                ->url(),
            ColorPicker::make('cta_bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_bg_color')),
            ColorPicker::make('cta_text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.cta_text_color')),
            Select::make('align')
                ->label(__('filament-mail-editor::filament-mail-editor.props.align'))
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center'),
        ];
    }
}
