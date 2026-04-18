<?php

namespace JeffersonGoncalves\FilamentMailEditor\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Support\ViewErrorBag;
use JeffersonGoncalves\FilamentMailEditor\FilamentMailEditorServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Livewire v4 requires errors to be shared with views
        $this->app['view']->share('errors', new ViewErrorBag);

        // Ensure config is available for tests
        config(['filament-mail-editor.app_url' => 'http://localhost']);
    }

    protected function defineDatabaseMigrations(): void
    {
        $migrationPath = __DIR__.'/../database/migrations';
        $files = glob($migrationPath.'/*.php.stub');

        foreach ($files as $file) {
            $migrationFile = $migrationPath.'/'.basename($file, '.stub');

            if (! file_exists($migrationFile)) {
                copy($file, $migrationFile);
            }
        }

        $this->loadMigrationsFrom($migrationPath);

        $this->beforeApplicationDestroyed(function () use ($migrationPath, $files) {
            foreach ($files as $file) {
                $migrationFile = $migrationPath.'/'.basename($file, '.stub');

                if (file_exists($migrationFile)) {
                    unlink($migrationFile);
                }
            }
        });
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            SchemasServiceProvider::class,
            FormsServiceProvider::class,
            TablesServiceProvider::class,
            FilamentServiceProvider::class,
            FilamentMailEditorServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }
}
