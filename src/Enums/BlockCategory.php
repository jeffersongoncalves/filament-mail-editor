<?php

namespace JeffersonGoncalves\FilamentMailEditor\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BlockCategory: string implements HasColor, HasIcon, HasLabel
{
    case Structure = 'structure';
    case Content = 'content';
    case Marketing = 'marketing';

    public function getLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.block_categories.'.$this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Structure => 'gray',
            self::Content => 'info',
            self::Marketing => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Structure => 'heroicon-o-rectangle-stack',
            self::Content => 'heroicon-o-document-text',
            self::Marketing => 'heroicon-o-megaphone',
        };
    }
}
