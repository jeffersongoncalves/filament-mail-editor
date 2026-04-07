<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class EditEmailTemplate extends EditRecord
{
    protected static string $resource = EmailTemplateResource::class;

    protected string $view = 'filament-mail-editor::resources.email-templates.pages.edit-email-template';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('duplicate')
                ->icon('heroicon-m-document-duplicate')
                ->requiresConfirmation()
                ->action(function () {
                    /** @var EmailTemplate $record */
                    $record = $this->record;
                    $clone = $record->replicate();
                    $clone->name = $clone->name.' (copy)';
                    $clone->slug = Str::slug($clone->name).'-'.time();
                    $clone->save();

                    return redirect(EmailTemplateResource::getUrl('edit', ['record' => $clone]));
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
