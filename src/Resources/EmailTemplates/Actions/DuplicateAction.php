<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;
use JeffersonGoncalves\MailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class DuplicateAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'duplicate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.duplicate'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.duplicate'))
            ->icon(Heroicon::OutlinedDocumentDuplicate)
            ->requiresConfirmation()
            ->action(function (EmailTemplate $record) {
                $clone = $record->replicate();
                $clone->name = $clone->name.' (copy)';
                $clone->slug = Str::slug($clone->name).'-'.time();
                $clone->status = TemplateStatus::Draft;
                $clone->locked_by = null;
                $clone->locked_at = null;
                $clone->approved_by = null;
                $clone->approved_at = null;
                $clone->save();

                return redirect(EmailTemplateResource::getUrl('edit', ['record' => $clone]));
            });
    }
}
