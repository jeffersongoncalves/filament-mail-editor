<?php

namespace JeffersonGoncalves\FilamentMailEditor\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class EmailMetricsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        $model = config('filament-mail-editor.model', EmailTemplate::class);

        return [
            Stat::make('Total Templates', $model::count())
                ->icon('heroicon-o-envelope')
                ->description('Email templates created'),
            Stat::make('Active Templates', $model::where('is_active', true)->count())
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->description('Currently active'),
            Stat::make('Categories', $model::whereNotNull('category')->distinct('category')->count('category'))
                ->icon('heroicon-o-tag')
                ->description('Unique categories'),
        ];
    }
}
