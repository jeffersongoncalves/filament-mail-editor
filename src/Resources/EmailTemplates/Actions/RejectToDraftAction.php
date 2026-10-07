<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\MailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class RejectToDraftAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'rejectToDraft';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.reject_to_draft'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.reject_to_draft'))
            ->icon(Heroicon::OutlinedXCircle)
            ->color('danger')
            ->requiresConfirmation()
            ->visible(fn (EmailTemplate $record): bool => in_array(
                $record->status,
                [TemplateStatus::Review, TemplateStatus::Approved]
            ))
            ->action(fn (EmailTemplate $record) => $record->rejectToDraft());
    }
}
