<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\ApproveAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\DuplicateAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\ExportHtmlAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\ExportJsonAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\RejectToDraftAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions\SubmitForReviewAction;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class ViewEmailTemplate extends ViewRecord
{
    protected static string $resource = EmailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            DuplicateAction::make(),
            ExportJsonAction::make(),
            ExportHtmlAction::make(),

            Actions\ActionGroup::make([
                SubmitForReviewAction::make(),
                ApproveAction::make(),
                RejectToDraftAction::make(),
            ])
                ->label(__('filament-mail-editor::filament-mail-editor.actions.workflow'))
                ->icon(Heroicon::OutlinedArrowPath),

            Actions\DeleteAction::make(),
        ];
    }
}
