<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Actions\MountableAction;
use Illuminate\Support\Str;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;
use JeffersonGoncalves\MailEditor\Support\TemplateImportExport;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportJsonAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'exportJson';
    }

    protected function setUp(): void
    {
        parent::setUp();

        static::configureAction($this);
    }

    /** Shared with {@see ExportJsonTableAction}: Filament 3 tables need Filament\Tables\Actions\Action. */
    public static function configureAction(MountableAction $action): void
    {
        $action
            ->label(__('filament-mail-editor::filament-mail-editor.actions.export_json'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.export_json'))
            ->icon('heroicon-o-arrow-down-tray')
            ->action(function (EmailTemplate $record): StreamedResponse {
                $json = (new TemplateImportExport)->exportJson($record);

                return response()->streamDownload(
                    fn () => print ($json),
                    Str::slug($record->name).'.json',
                    ['Content-Type' => 'application/json']
                );
            });
    }
}
