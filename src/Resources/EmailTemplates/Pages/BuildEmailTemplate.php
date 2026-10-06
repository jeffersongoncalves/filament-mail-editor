<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\BackToEditAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class BuildEmailTemplate extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EmailTemplateResource::class;

    protected static string $view = 'filament-mail-editor::resources.email-templates.pages.build-email-template';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }

    public function getTitle(): string
    {
        return __('filament-mail-editor::filament-mail-editor.builder.heading');
    }

    public function getHeading(): string
    {
        return $this->getRecord()->name ?? $this->getTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            BackToEditAction::make(),
        ];
    }
}
