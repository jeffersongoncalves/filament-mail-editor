<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Actions;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class BuildEmailTemplate extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EmailTemplateResource::class;

    protected string $view = 'filament-mail-editor::resources.email-templates.pages.build-email-template';

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
            Actions\Action::make('back')
                ->label(__('filament-mail-editor::filament-mail-editor.builder.back_to_edit'))
                ->icon(Heroicon::OutlinedArrowUturnLeft)
                ->color('gray')
                ->url(fn (): string => EmailTemplateResource::getUrl('edit', ['record' => $this->getRecord()])),
        ];
    }
}
