<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class ApproveAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'approve';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.approve'))
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (EmailTemplate $record): bool => $record->status === TemplateStatus::Review)
            ->action(fn (EmailTemplate $record) => $record->approve());
    }
}
