<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportHtmlAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'exportHtml';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.export_html'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.export_html'))
            ->icon(Heroicon::OutlinedCodeBracket)
            ->action(function (EmailTemplate $record): StreamedResponse {
                $html = $record->render();

                return response()->streamDownload(
                    fn () => print ($html),
                    Str::slug($record->name).'.html',
                    ['Content-Type' => 'text/html']
                );
            });
    }
}
