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

        // Load migrations in dependency order matching service provider registration
        $migrationsPath = __DIR__.'/../database/migrations';
        $orderedMigrations = [
            'create_email_template_categories_table',
            'create_email_templates_table',
            'create_saved_email_blocks_table',
            'create_email_template_variants_table',
            'create_email_template_versions_table',
            'create_email_brand_kits_table',
        ];

        foreach ($orderedMigrations as $migration) {
            $file = $migrationsPath.'/'.$migration.'.php';
            if (file_exists($file)) {
                $this->loadMigrationsFrom($file);
            }
        }

        // Livewire v4 requires errors to be shared with views
        $this->app['view']->share('errors', new ViewErrorBag);

        // Ensure config is available for tests
        config(['filament-mail-editor.app_url' => 'http://localhost']);
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
