<?php

namespace JeffersonGoncalves\FilamentMailEditor\Tests;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\FilamentMailEditor\FilamentMailEditorPlugin;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin(FilamentMailEditorPlugin::make());
    }
}
