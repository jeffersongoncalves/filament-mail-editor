<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\CouponBlock as BaseCouponBlock;

class CouponBlock extends BaseCouponBlock implements HasPropsSchema
{
    public static function propsSchema(): array
    {
        return [
            TextInput::make('code')
                ->label(__('filament-mail-editor::filament-mail-editor.props.code'))
                ->required(),
            TextInput::make('discount_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.discount'))
                ->placeholder('20% OFF'),
            TextInput::make('expires_text')
                ->label(__('filament-mail-editor::filament-mail-editor.props.expires'))
                ->placeholder('Valid until Dec 31'),
            ColorPicker::make('bg_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.bg_color'))
                ->default('#fff3cd'),
            ColorPicker::make('border_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.border_color'))
                ->default('#EF9F27'),
            Select::make('border_style')
                ->label(__('filament-mail-editor::filament-mail-editor.props.border_style'))
                ->options([
                    'dashed' => 'Dashed',
                    'solid' => 'Solid',
                ])
                ->default('dashed'),
            ColorPicker::make('text_color')
                ->label(__('filament-mail-editor::filament-mail-editor.props.text_color'))
                ->default('#333333'),
        ];
    }
}
