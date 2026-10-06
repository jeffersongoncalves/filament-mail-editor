<?php

use Filament\Facades\Filament;
use Illuminate\Foundation\Auth\User;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailBrandKit;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplateCategory;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTheme;
use JeffersonGoncalves\FilamentMailEditor\Models\SavedEmailBlock;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Pages as BrandKitPages;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplateCategories\Pages as CategoryPages;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages as TemplatePages;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailThemes\Pages as ThemePages;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Pages as SavedBlockPages;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->actingAs(User::forceCreate([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => 'secret',
    ]));

    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('renders the list and create pages', function (string $page) {
    livewire($page)->assertSuccessful();
})->with([
    TemplatePages\ListEmailTemplates::class,
    TemplatePages\CreateEmailTemplate::class,
    CategoryPages\ListEmailTemplateCategories::class,
    CategoryPages\CreateEmailTemplateCategory::class,
    BrandKitPages\ListEmailBrandKits::class,
    BrandKitPages\CreateEmailBrandKit::class,
    SavedBlockPages\ListSavedEmailBlocks::class,
    SavedBlockPages\CreateSavedEmailBlock::class,
    ThemePages\ListEmailThemes::class,
    ThemePages\CreateEmailTheme::class,
]);

it('renders the view pages', function (string $page, string $model) {
    $record = $model::factory()->create();

    livewire($page, ['record' => $record->getRouteKey()])
        ->assertSuccessful()
        ->assertSee($record->name);
})->with([
    [TemplatePages\ViewEmailTemplate::class, EmailTemplate::class],
    [TemplatePages\BuildEmailTemplate::class, EmailTemplate::class],
    [CategoryPages\ViewEmailTemplateCategory::class, EmailTemplateCategory::class],
    [BrandKitPages\ViewEmailBrandKit::class, EmailBrandKit::class],
    [SavedBlockPages\ViewSavedEmailBlock::class, SavedEmailBlock::class],
    [ThemePages\ViewEmailTheme::class, EmailTheme::class],
]);

it('renders the edit pages filled with the record', function (string $page, string $model) {
    $record = $model::factory()->create();

    livewire($page, ['record' => $record->getRouteKey()])
        ->assertSuccessful()
        ->assertFormSet(['name' => $record->name]);
})->with([
    [TemplatePages\EditEmailTemplate::class, EmailTemplate::class],
    [CategoryPages\EditEmailTemplateCategory::class, EmailTemplateCategory::class],
    [BrandKitPages\EditEmailBrandKit::class, EmailBrandKit::class],
    [SavedBlockPages\EditSavedEmailBlock::class, SavedEmailBlock::class],
    [ThemePages\EditEmailTheme::class, EmailTheme::class],
]);

it('duplicates a template from the table', function () {
    $template = EmailTemplate::factory()->create(['name' => 'Welcome']);

    livewire(TemplatePages\ListEmailTemplates::class)
        ->assertCanSeeTableRecords([$template])
        ->assertTableActionVisible('openBuilder', $template)
        ->callTableAction('duplicate', $template);

    expect(EmailTemplate::where('name', 'Welcome (copy)')->exists())->toBeTrue();
});

it('sets a theme and a brand kit as default from the table', function () {
    $theme = EmailTheme::factory()->create(['is_default' => false]);
    $kit = EmailBrandKit::factory()->create(['is_default' => false]);

    livewire(ThemePages\ListEmailThemes::class)->callTableAction('setDefault', $theme);
    livewire(BrandKitPages\ListEmailBrandKits::class)->callTableAction('setDefault', $kit);

    expect($theme->refresh()->is_default)->toBeTrue()
        ->and($kit->refresh()->is_default)->toBeTrue();
});
