<div class="filament-hidden">

![Filament Mail Editor](https://raw.githubusercontent.com/jeffersongoncalves/filament-mail-editor/3.x/art/jeffersongoncalves-filament-mail-editor.png)

</div>

# Filament Mail Editor

[![Buy Me A Coffee](https://img.shields.io/badge/Buy%20Me%20A%20Coffee-support-FFDD00?style=flat-square&logo=buy-me-a-coffee&logoColor=black)](https://buymeacoffee.com/jeffersongoncalves)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-mail-editor.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-mail-editor)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-mail-editor/tests.yml?branch=3.x&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/filament-mail-editor/actions?query=workflow%3Atests+branch%3A3.x)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-mail-editor/fix-php-code-style-issues.yml?branch=3.x&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-mail-editor/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3A3.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-mail-editor.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-mail-editor)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/filament-mail-editor.svg?style=flat-square)](LICENSE.md)

Visual email template builder for Filament v5. A drag-and-drop Livewire editor that outputs table-based, inline-CSS HTML compatible with every major email client (Gmail, Outlook, Apple Mail).

The templates, blocks, rendering, workflow and `Mail::template()` integration live in [jeffersongoncalves/laravel-mail-editor](https://github.com/jeffersongoncalves/laravel-mail-editor), which is installed automatically. This plugin adds the Filament admin: resources, the drag-and-drop builder and the block forms.

## Version Compatibility

| Plugin Version | Filament |
|----------------|----------|
| 1.x | v3 |
| 2.x | v4 |
| 3.x | v5 |

## Features

- **Drag-and-drop builder** with live iframe preview (desktop/mobile/dark-mode), undo/redo and keyboard shortcuts
- **Filament resources** for templates, categories, brand kits, themes and the saved block library
- **Review workflow** actions (submit, approve, reject) with concurrent editing lock
- **Quality panel** — accessibility (WCAG), spam score, link validation, preheader/alt text
- **Metrics widget** for the dashboard
- Everything from [laravel-mail-editor](https://github.com/jeffersongoncalves/laravel-mail-editor): 22 email-safe blocks, inline-CSS HTML and plain-text export, template variables, version history, A/B variants

## Requirements

- PHP `^8.3`
- Filament `^5.0`
- `ext-gd` (for countdown image rendering)

## Installation

```bash
composer require jeffersongoncalves/filament-mail-editor:^3.0
```

### Publish and run migrations

```bash
php artisan vendor:publish --tag="mail-editor-migrations"
php artisan migrate
```

### Publish config (optional)

```bash
php artisan vendor:publish --tag="mail-editor-config"
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
php artisan db:seed --class="JeffersonGoncalves\MailEditor\Database\Seeders\MailEditorSeeder"
```

## Usage

Sending, rendering, variables and Artisan commands come from laravel-mail-editor — see [its README](https://github.com/jeffersongoncalves/laravel-mail-editor#usage). For example:

```php
use Illuminate\Support\Facades\Mail;

Mail::template('welcome-email', ['user_name' => $user->name])->to($user->email)->send();
```

### Register a custom block

Register the block in `config/mail-editor.php` as described in [laravel-mail-editor](https://github.com/jeffersongoncalves/laravel-mail-editor#register-a-custom-block). To edit its props in the Filament block library, also implement `JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema`:

```php
use Filament\Forms\Components\TextInput;
use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\MailEditor\Blocks\AbstractEmailBlock;

class MyCustomBlock extends AbstractEmailBlock implements HasPropsSchema
{
    // type(), label(), icon(), defaultProps() ...

    public static function propsSchema(): array
    {
        return [
            TextInput::make('title')->required(),
        ];
    }
}
```

## Upgrading from 3.0

3.1 moved the Laravel core into [jeffersongoncalves/laravel-mail-editor](https://github.com/jeffersongoncalves/laravel-mail-editor):

- Models, enums, events, support classes and the seeder moved from `JeffersonGoncalves\FilamentMailEditor\…` to `JeffersonGoncalves\MailEditor\…`.
- Config, migrations and translations of the core use the `mail-editor` key: `config/mail-editor.php`, `--tag="mail-editor-migrations"`, `--tag="mail-editor-config"`.
- The preview and countdown routes moved from `/filament-mail-editor/*` to `/mail-editor/*` (names `mail-editor.preview` / `mail-editor.countdown`).
- JSON exports use the `mail-editor` format id; files exported with the old `filament-mail-editor` id still import.

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
