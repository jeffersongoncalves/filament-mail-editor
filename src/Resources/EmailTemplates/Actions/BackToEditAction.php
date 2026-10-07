<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class BackToEditAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'backToEdit';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.builder.back_to_edit'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.builder.back_to_edit'))
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('gray')
            ->url(fn (EmailTemplate $record): string => EmailTemplateResource::getUrl('edit', ['record' => $record]));
    }
}
