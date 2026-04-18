<?php

use Illuminate\Support\Facades\Route;
use JeffersonGoncalves\FilamentMailEditor\Http\Controllers\CountdownController;
use JeffersonGoncalves\FilamentMailEditor\Http\Controllers\PreviewController;

Route::middleware(config('filament-mail-editor.preview_route_middleware', ['web', 'auth']))
    ->prefix('filament-mail-editor')
    ->name('filament-mail-editor.')
    ->group(function () {
        Route::get('/preview', PreviewController::class)->name('preview');
        Route::get('/countdown', CountdownController::class)->name('countdown');
    });
