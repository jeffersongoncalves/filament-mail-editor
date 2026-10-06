<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Actions\MountableAction;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class DuplicateAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'duplicate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        static::configureAction($this);
    }

    /** Shared with {@see DuplicateTableAction}: Filament 3 tables need Filament\Tables\Actions\Action. */
    public static function configureAction(MountableAction $action): void
    {
        $action
            ->label(__('filament-mail-editor::filament-mail-editor.actions.duplicate'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.duplicate'))
            ->icon('heroicon-o-document-duplicate')
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
