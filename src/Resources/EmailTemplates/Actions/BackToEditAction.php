<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\EmailTemplateResource;

class BackToEditAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'backToEdit';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('filament-mail-editor::filament-mail-editor.builder.back_to_edit'))
            ->icon(Heroicon::OutlinedArrowUturnLeft)
            ->color('gray')
            ->url(fn (EmailTemplate $record): string => EmailTemplateResource::getUrl('edit', ['record' => $record]));
    }
}
