<div class="filament-hidden">

![Filament Mail Editor](https://raw.githubusercontent.com/jeffersongoncalves/filament-mail-editor/3.x/art/jeffersongoncalves-filament-mail-editor.png)

</div>

# Filament Mail Editor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-mail-editor.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-mail-editor)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-mail-editor/tests.yml?branch=3.x&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/filament-mail-editor/actions?query=workflow%3Atests+branch%3A3.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-mail-editor.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-mail-editor)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/filament-mail-editor.svg?style=flat-square)](LICENSE.md)

Visual email template builder for Filament v5. A drag-and-drop Livewire editor that outputs table-based, inline-CSS HTML compatible with every major email client (Gmail, Outlook, Apple Mail).

## Version Compatibility

| Plugin Version | Filament | Laravel | PHP |
|---------------|----------|---------|-----|
| 3.x | ^5.0 | ^12.0 \| ^13.0 | ^8.3 |

## Features

- **22 ready-to-use blocks** across three categories: structure, content, marketing
- **Drag-and-drop builder** with live iframe preview (desktop/mobile/dark-mode)
- **Table-based HTML export** with inline CSS via `CssToInlineStyles`
- **Template variables** — `{{var}}`, fallbacks `{{var|default}}`, conditionals `{{#if}}`, loops `{{#each}}`
- **Workflow** — draft → review → approved, with concurrent editing lock
- **Version history** — immutable snapshots with one-click restore
- **A/B testing** — multiple variants with send percentage split and winner flag
- **Brand kits** — reusable logo, colors, typography, social links
- **Saved block library** — per-user or global reusable blocks
- **Quality checks** — accessibility (WCAG), spam score, link validation, preheader/alt text
- **Laravel Mail integration** — `Mail::template($slug, $variables)->to(...)->send()`

## Requirements

- PHP `^8.3`
- Laravel `^12.0` or `^13.0`
- Filament `^5.0`
- `ext-gd` (for countdown image rendering)

## Installation

```bash
composer require jeffersongoncalves/filament-mail-editor:^3.0
```

### Publish config

```bash
php artisan vendor:publish --tag="filament-mail-editor-config"
```

### Publish and run migrations

```bash
php artisan vendor:publish --tag="filament-mail-editor-migrations"
php artisan migrate
```

### Register the plugin in your Filament panel

```php
use JeffersonGoncalves\FilamentMailEditor\FilamentMailEditorPlugin;

public function panel(Panel $panel): Panel
{
    return $panel->plugins([
        FilamentMailEditorPlugin::make(),
    ]);
}
```

### Seed demo data (optional)

```bash
php artisan db:seed --class="JeffersonGoncalves\FilamentMailEditor\Database\Seeders\FilamentMailEditorSeeder"
```

## Usage

### Send a template email

```php
use Illuminate\Support\Facades\Mail;

Mail::template('welcome-email', [
    'user_name' => $user->name,
    'app_url' => config('app.url'),
])->to($user->email)->send();
```

### Render a template to HTML

```php
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

$html = EmailTemplate::where('slug', 'welcome-email')
    ->first()
    ->render(['user_name' => 'Alice']);
```

### Generate a template via Artisan

```bash
php artisan mail-editor:make-template "Welcome Email"
```

### Release stale editing locks

```bash
php artisan mail-editor:release-locks
```

## Block Catalog

**Structure:** Preheader · Header · Footer · Spacer
**Content:** Heading · Paragraph · Button · Image · Divider · List · Alert · TwoColumns · ThreeColumns
**Marketing:** Hero · ProductCard · Coupon · Testimonial · Rating · VideoThumb · DataTable · Countdown · LogoGrid

### Register a custom block

```php
// config/filament-mail-editor.php
'blocks' => [
    \App\Mail\Blocks\MyCustomBlock::class,
],
```

Your block must implement `JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\EmailBlock` (or extend `AbstractEmailBlock`).

## Template Variables

```
Hello {{user_name|there}}!

{{#if is_premium}}
  You have premium access.
{{#else}}
  Upgrade anytime.
{{/if}}

{{#each items}}
  - {{this.name}}: {{this.price}}
{{/each}}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
