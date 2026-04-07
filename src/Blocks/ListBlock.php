<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

/**
 * Renders a list using table rows instead of HTML list elements.
 *
 * Email clients have inconsistent support for <ul>/<ol>/<li> and CSS list-style.
 * This block uses a table where each row has a bullet cell and a text cell,
 * ensuring consistent rendering across Gmail, Outlook, and Apple Mail.
 *
 * @see https://www.emailonacid.com/blog/article/email-development/html-lists-in-email/
 */
class ListBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'list';
    }

    public static function label(): string
    {
        return 'List';
    }

    public static function icon(): string
    {
        return 'heroicon-o-list-bullet';
    }

    public static function category(): string
    {
        return 'content';
    }

    public static function defaultProps(): array
    {
        return [
            'items' => [],
            'type' => 'unordered',
            'bullet_char' => "\u{2022}",
            'bullet_color' => '#378ADD',
            'indent' => 0,
            'color' => '#333333',
            'font_size' => 14,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('List Items')
                ->schema([
                    TextInput::make('text')
                        ->label('Text')
                        ->required(),
                    TextInput::make('link')
                        ->label('Link URL')
                        ->url(),
                ])
                ->defaultItems(1)
                ->columnSpanFull(),
            Select::make('type')
                ->label('List Type')
                ->options([
                    'unordered' => 'Unordered',
                    'ordered' => 'Ordered',
                ])
                ->default('unordered'),
            TextInput::make('bullet_char')
                ->label('Bullet Character')
                ->default("\u{2022}"),
            ColorPicker::make('bullet_color')
                ->label('Bullet Color')
                ->default('#378ADD'),
            TextInput::make('indent')
                ->label('Indent')
                ->numeric()
                ->suffix('px')
                ->default(0),
            ColorPicker::make('color')
                ->label('Text Color')
                ->default('#333333'),
            TextInput::make('font_size')
                ->label('Font Size')
                ->numeric()
                ->suffix('px')
                ->default(14),
        ];
    }
}
