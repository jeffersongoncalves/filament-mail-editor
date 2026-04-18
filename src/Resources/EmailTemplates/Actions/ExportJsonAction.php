<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Support\TemplateImportExport;
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

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.export_json'))
            ->icon(Heroicon::OutlinedArrowDownTray)
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
