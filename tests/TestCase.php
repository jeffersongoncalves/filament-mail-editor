<?php

namespace JeffersonGoncalves\FilamentMailEditor\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Support\ViewErrorBag;
use JeffersonGoncalves\FilamentMailEditor\FilamentMailEditorServiceProvider;
use JeffersonGoncalves\MailEditor\MailEditorServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use ReflectionClass;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Livewire v4 requires errors to be shared with views
        $this->app['view']->share('errors', new ViewErrorBag);

        // Ensure config is available for tests
        config(['mail-editor.app_url' => 'http://localhost']);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();

        // migrations ship as publishable stubs in jeffersongoncalves/laravel-mail-editor; run them in place
        $stubs = glob(dirname((string) (new ReflectionClass(MailEditorServiceProvider::class))->getFileName(), 2).'/database/migrations/*.php.stub');
        sort($stubs);

        foreach ($stubs as $stub) {
            (include $stub)->up();
        }
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeCaptureDirectiveServiceProvider::class,
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            ActionsServiceProvider::class,
            SchemasServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentServiceProvider::class,
            MailEditorServiceProvider::class,
            FilamentMailEditorServiceProvider::class,
            TestPanelProvider::class,
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
