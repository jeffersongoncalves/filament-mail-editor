<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class OpenBuilderAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'openBuilder';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.actions.open_builder'))
            ->tooltip(__('filament-mail-editor::filament-mail-editor.actions.open_builder'))
            ->icon(Heroicon::OutlinedSquares2x2)
            ->color('primary')
            ->url(fn (EmailTemplate $record): string => EmailTemplateResource::getUrl('build', ['record' => $record]));
    }
}
