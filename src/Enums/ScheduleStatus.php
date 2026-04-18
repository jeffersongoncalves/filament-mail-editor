<?php

namespace JeffersonGoncalves\FilamentMailEditor\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ScheduleStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Sent = 'sent';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.schedule_statuses.'.$this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Processing => 'info',
            self::Sent => 'success',
            self::Failed => 'danger',
            self::Cancelled => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Pending => 'heroicon-o-clock',
            self::Processing => 'heroicon-o-arrow-path',
            self::Sent => 'heroicon-o-check-circle',
            self::Failed => 'heroicon-o-exclamation-triangle',
            self::Cancelled => 'heroicon-o-x-circle',
        };
    }
}
