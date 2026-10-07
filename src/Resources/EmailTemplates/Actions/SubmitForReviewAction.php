<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use JeffersonGoncalves\MailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class SubmitForReviewAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'submitForReview';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.submit_for_review'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.submit_for_review'))
            ->icon('heroicon-o-paper-airplane')
            ->color('warning')
            ->requiresConfirmation()
            ->visible(fn (EmailTemplate $record): bool => $record->status === TemplateStatus::Draft)
            ->action(fn (EmailTemplate $record) => $record->submitForReview());
    }
}
