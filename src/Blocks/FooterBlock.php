<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\FooterBlock as BaseFooterBlock;

class FooterBlock extends BaseFooterBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('address')
                ->label(__('filament-mail-editor::filament-mail-editor.props.address'))
                ->required(),
            TextInput::make('unsubscribe_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.unsubscribe_url'))
                ->url()
                ->required(),
            TextInput::make('unsubscribe_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.unsubscribe_text'))
                ->default('Unsubscribe'),
            TextInput::make('web_version_url')
                ->label(__('filament-mail-editor::filament-mail-editor.props.web_version_url'))
                ->url(),
            TextInput::make('copyright')
                ->label(__('filament-mail-editor::filament-mail-editor.props.copyright')),
            Repeater::make('social_links')
                ->label(__('filament-mail-editor::filament-mail-editor.sections.social_links'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.name'))
                        ->required(),
                    TextInput::make('url')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.url'))
                        ->url()
                        ->required(),
                    TextInput::make('icon_src')
                        ->label(__('filament-mail-editor::filament-mail-editor.props.logo_src'))
                        ->url(),
                ])
                ->defaultItems(0)
                ->columnSpanFull(),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color')),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color')),
            TextInput::make('font_size')
                ->label(__('filament-mail-editor::filament-mail-editor.props.font_size'))
                ->numeric()
                ->suffix('px')
                ->default(11),
        ];
    }
}
