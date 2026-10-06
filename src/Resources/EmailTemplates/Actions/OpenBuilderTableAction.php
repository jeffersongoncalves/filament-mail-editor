<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Tables\Actions\Action;

class OpenBuilderTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return OpenBuilderAction::getDefaultName();
    }

    protected function setUp(): void
    {
        parent::setUp();

        OpenBuilderAction::configureAction($this);
    }
}
