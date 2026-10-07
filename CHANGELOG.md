# Changelog

All notable changes to this project will be documented in this file.

## 3.1.0 - 2026-10-06

The Laravel core of this plugin now lives in [jeffersongoncalves/laravel-mail-editor](https://github.com/jeffersongoncalves/laravel-mail-editor), which is installed automatically. This plugin keeps the Filament layer: resources, the drag-and-drop builder, the metrics widget and the block forms.

### Breaking changes

- Models, enums, events, support classes and the seeder moved from `JeffersonGoncalves\FilamentMailEditor\…` to `JeffersonGoncalves\MailEditor\…`.
- Core config, migrations and translations use the `mail-editor` key: `config/mail-editor.php`, `--tag="mail-editor-migrations"`, `--tag="mail-editor-config"`.
- Preview and countdown routes moved from `/filament-mail-editor/*` to `/mail-editor/*` (`mail-editor.preview` / `mail-editor.countdown`).
- JSON exports use the `mail-editor` format id; files exported with `filament-mail-editor` still import.

### Added

- `HasPropsSchema` contract to give custom blocks a Filament form in the block library.
- Smoke tests for every resource page and the custom table actions.

## 3.0.0 - 2026-10-06

First release for **Filament v5**.

Visual email template builder: drag-and-drop editor with 22 blocks, live preview, table-based inline-CSS HTML export, template variables, review workflow with editing locks, version history, A/B variants, brand kits, saved block library and quality/accessibility/spam checks.

```bash
composer require jeffersongoncalves/filament-mail-editor:^3.0


```