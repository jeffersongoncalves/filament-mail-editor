<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Tables\Actions\Action;

class ExportJsonTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return ExportJsonAction::getDefaultName();
    }

    protected function setUp(): void
    {
        parent::setUp();

        ExportJsonAction::configureAction($this);
    }
}
