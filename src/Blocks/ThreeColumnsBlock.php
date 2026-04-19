<?php

namespace JeffersonGoncalves\FilamentMailEditor\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

/**
 * Renders a responsive three-column layout with mobile stacking.
 *
 * Uses MSO conditional comments for Outlook table layout. Each column takes
 * 33.33% width on desktop and stacks to 100% width on mobile via media query.
 *
 * @see https://www.emailonacid.com/blog/article/email-development/multi-column-email-layouts/
 */
class ThreeColumnsBlock extends AbstractEmailBlock
{
    public static function type(): string
    {
        return 'three-columns';
    }

    public static function label(): string
    {
        return 'Three Columns';
    }

    public static function icon(): string
    {
        return 'heroicon-o-view-columns';
    }

    public static function category(): string
    {
        return 'structure';
    }

    public static function defaultProps(): array
    {
        return [
            'col1_content' => '',
            'col2_content' => '',
            'col3_content' => '',
            'gap' => 12,
            'stack_mobile' => true,
        ];
    }

    public static function propsSchema(): array
    {
        return [
            RichEditor::make('col1_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.left_column'))
                ->columnSpanFull(),
            RichEditor::make('col2_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.center_column'))
                ->columnSpanFull(),
            RichEditor::make('col3_content')
                ->label(__('filament-mail-editor::filament-mail-editor.props.right_column'))
                ->columnSpanFull(),
            TextInput::make('gap')
                ->label(__('filament-mail-editor::filament-mail-editor.props.gap'))
                ->numeric()
                ->suffix('px')
                ->default(12),
            Toggle::make('stack_mobile')
                ->label(__('filament-mail-editor::filament-mail-editor.props.stack_on_mobile'))
                ->default(true),
        ];
    }

    public function getMediaQueries(): string
    {
        return '@media only screen and (max-width: 600px) { .three-col-td { display: block !important; width: 100% !important; padding-left: 0 !important; padding-right: 0 !important; } }';
    }
}
