<?php

declare(strict_types=1);

namespace JeffersonGoncalves\FilamentMailEditor\Database\Seeders;

use Illuminate\Database\Seeder;

final class FilamentMailEditorSeeder extends Seeder
{
    /**
     * Orchestrator seeder. Run via:
     *   php artisan db:seed --class="JeffersonGoncalves\\FilamentMailEditor\\Database\\Seeders\\FilamentMailEditorSeeder"
     */
    public function run(): void
    {
        $this->call([
            EmailTemplateCategorySeeder::class,
            EmailBrandKitSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}
