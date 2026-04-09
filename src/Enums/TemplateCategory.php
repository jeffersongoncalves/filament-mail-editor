<?php

namespace JeffersonGoncalves\FilamentMailEditor\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TemplateCategory: string implements HasColor, HasIcon, HasLabel
{
    case Transactional = 'transactional';
    case Marketing = 'marketing';
    case Notification = 'notification';

    public function getLabel(): string
    {
        return match ($this) {
            self::Transactional => 'Transactional',
            self::Marketing => 'Marketing',
            self::Notification => 'Notification',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Transactional => 'info',
            self::Marketing => 'success',
            self::Notification => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Transactional => 'heroicon-o-paper-airplane',
            self::Marketing => 'heroicon-o-megaphone',
            self::Notification => 'heroicon-o-bell',
        };
    }
}
