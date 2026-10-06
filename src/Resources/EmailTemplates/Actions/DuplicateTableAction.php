<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Actions;

use Filament\Tables\Actions\Action;

class DuplicateTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return DuplicateAction::getDefaultName();
    }

    protected function setUp(): void
    {
        parent::setUp();

        DuplicateAction::configureAction($this);
    }
}
