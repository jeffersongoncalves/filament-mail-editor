<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;
use JeffersonGoncalves\FilamentMailEditor\Support\TemplateImportExport;

class ViewEmailTemplate extends ViewRecord
{
    protected static string $resource = EmailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('duplicate')
                ->icon('heroicon-m-document-duplicate')
                ->requiresConfirmation()
                ->action(function () {
                    /** @var EmailTemplate $record */
                    $record = $this->record;
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
                }),

            Actions\Action::make('exportJson')
                ->label('Export JSON')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(function () {
                    /** @var EmailTemplate $record */
                    $record = $this->record;
                    $json = (new TemplateImportExport)->exportJson($record);

                    return response()->streamDownload(
                        fn () => print ($json),
                        Str::slug($record->name).'.json',
                        ['Content-Type' => 'application/json']
                    );
                }),

            Actions\Action::make('exportHtml')
                ->label('Export HTML')
                ->icon('heroicon-m-code-bracket')
                ->action(function () {
                    /** @var EmailTemplate $record */
                    $record = $this->record;
                    $html = $record->render();

                    return response()->streamDownload(
                        fn () => print ($html),
                        Str::slug($record->name).'.html',
                        ['Content-Type' => 'text/html']
                    );
                }),

            Actions\ActionGroup::make([
                Actions\Action::make('submitForReview')
                    ->icon('heroicon-m-paper-airplane')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(function () {
                        /** @var EmailTemplate $record */
                        $record = $this->record;

                        return $record->status === TemplateStatus::Draft;
                    })
                    ->action(function () {
                        /** @var EmailTemplate $record */
                        $record = $this->record;
                        $record->submitForReview();
                        $this->refreshFormData(['status']);
                    }),

                Actions\Action::make('approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(function () {
                        /** @var EmailTemplate $record */
                        $record = $this->record;

                        return $record->status === TemplateStatus::Review;
                    })
                    ->action(function () {
                        /** @var EmailTemplate $record */
                        $record = $this->record;
                        $record->approve();
                        $this->refreshFormData(['status', 'approved_by', 'approved_at']);
                    }),

                Actions\Action::make('rejectToDraft')
                    ->label('Return to Draft')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(function () {
                        /** @var EmailTemplate $record */
                        $record = $this->record;

                        return in_array($record->status, [TemplateStatus::Review, TemplateStatus::Approved]);
                    })
                    ->action(function () {
                        /** @var EmailTemplate $record */
                        $record = $this->record;
                        $record->rejectToDraft();
                        $this->refreshFormData(['status', 'approved_by', 'approved_at']);
                    }),
            ])
                ->label('Workflow')
                ->icon('heroicon-m-arrow-path'),

            Actions\DeleteAction::make(),
        ];
    }
}
