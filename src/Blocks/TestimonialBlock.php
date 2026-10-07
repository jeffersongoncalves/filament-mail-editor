<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\TestimonialBlock as BaseTestimonialBlock;

class TestimonialBlock extends BaseTestimonialBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            Textarea::make('quote')
                ->label(__('filament-mail-editor::filament-mail-editor.props.quote'))
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            TextInput::make('author')
                ->label(__('filament-mail-editor::filament-mail-editor.props.author'))
                ->required(),
            TextInput::make('role')
                ->label(__('filament-mail-editor::filament-mail-editor.props.role')),
            TextInput::make('avatar_src')
                ->label(__('filament-mail-editor::filament-mail-editor.props.avatar_src'))
                ->url(),
            ColorPicker::make('accent_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.accent_color')),
        ];
    }
}
