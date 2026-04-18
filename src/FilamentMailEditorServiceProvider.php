<?php

namespace JeffersonGoncalves\FilamentMailEditor;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Mail;
use JeffersonGoncalves\FilamentMailEditor\Blocks\AlertBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\ButtonBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\CountdownBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\CouponBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\DataTableBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\DividerBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\FooterBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\HeaderBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\HeadingBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\HeroBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\ImageBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\ListBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\LogoGridBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\ParagraphBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\PreheaderBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\ProductCardBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\RatingBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\SpacerBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\TestimonialBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\ThreeColumnsBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\TwoColumnsBlock;
use JeffersonGoncalves\FilamentMailEditor\Blocks\VideoThumbBlock;
use JeffersonGoncalves\FilamentMailEditor\Commands\MakeTemplateCommand;
use JeffersonGoncalves\FilamentMailEditor\Commands\ReleaseLocksCommand;
use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;
use JeffersonGoncalves\FilamentMailEditor\Support\TemplateMailableBridge;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentMailEditorServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-mail-editor';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasMigrations([
                'create_email_template_categories_table',
                'create_email_templates_table',
                'create_saved_email_blocks_table',
                'create_email_template_variants_table',
                'create_email_template_versions_table',
                'create_email_brand_kits_table',
                'create_email_template_activities_table',
                'create_email_template_notifications_table',
                'create_email_template_schedules_table',
            ])
            ->hasCommands([
                MakeTemplateCommand::class,
                ReleaseLocksCommand::class,
            ]);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(BlockRegistry::class, function () {
            $registry = new BlockRegistry;

            $registry
                ->register(PreheaderBlock::class)
                ->register(HeaderBlock::class)
                ->register(HeroBlock::class)
                ->register(HeadingBlock::class)
                ->register(ParagraphBlock::class)
                ->register(ButtonBlock::class)
                ->register(ImageBlock::class)
                ->register(DividerBlock::class)
                ->register(SpacerBlock::class)
                ->register(TestimonialBlock::class)
                ->register(AlertBlock::class)
                ->register(TwoColumnsBlock::class)
                ->register(ThreeColumnsBlock::class)
                ->register(FooterBlock::class)
                ->register(ListBlock::class)
                ->register(VideoThumbBlock::class)
                ->register(ProductCardBlock::class)
                ->register(RatingBlock::class)
                ->register(DataTableBlock::class)
                ->register(CouponBlock::class)
                ->register(LogoGridBlock::class)
                ->register(CountdownBlock::class);

            foreach (config('filament-mail-editor.blocks', []) as $blockClass) {
                $registry->register($blockClass);
            }

            return $registry;
        });
    }

    public function packageBooted(): void
    {
        Livewire::component('email-builder', EmailBuilder::class);

        FilamentAsset::register([
            Css::make('filament-mail-editor-styles', __DIR__.'/../resources/dist/email-builder.css'),
            Js::make('filament-mail-editor-scripts', __DIR__.'/../resources/dist/email-builder.js'),
        ], 'jeffersongoncalves/filament-mail-editor');

        $this->registerMailMacro();
    }

    protected function registerMailMacro(): void
    {
        if (! Mail::hasMacro('template')) {
            Mail::macro('template', function (string $slug, array $variables = []) {
                return new TemplateMailableBridge($slug, $variables);
            });
        }
    }
}
