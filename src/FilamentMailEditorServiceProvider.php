<?php

namespace JeffersonGoncalves\FilamentMailEditor;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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
use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;
use JeffersonGoncalves\MailEditor\Blocks\Contracts\EmailBlock;
use JeffersonGoncalves\MailEditor\Support\BlockRegistry;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentMailEditorServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-mail-editor';

    /**
     * Same blocks as jeffersongoncalves/laravel-mail-editor, plus the Filament form for their props.
     *
     * @var list<class-string<EmailBlock&Blocks\Contracts\HasPropsSchema>>
     */
    public const BLOCKS = [
        PreheaderBlock::class,
        HeaderBlock::class,
        HeroBlock::class,
        HeadingBlock::class,
        ParagraphBlock::class,
        ButtonBlock::class,
        ImageBlock::class,
        DividerBlock::class,
        SpacerBlock::class,
        TestimonialBlock::class,
        AlertBlock::class,
        TwoColumnsBlock::class,
        ThreeColumnsBlock::class,
        FooterBlock::class,
        ListBlock::class,
        VideoThumbBlock::class,
        ProductCardBlock::class,
        RatingBlock::class,
        DataTableBlock::class,
        CouponBlock::class,
        LogoGridBlock::class,
        CountdownBlock::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }

    public function packageRegistered(): void
    {
        // Built-in types are replaced by their Filament subclasses; custom blocks from config('mail-editor.blocks') stay.
        $this->app->extend(BlockRegistry::class, function (BlockRegistry $registry): BlockRegistry {
            foreach (static::BLOCKS as $blockClass) {
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
    }
}
