<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailBrandKits\Actions;

use Filament\Tables\Actions\Action;

class SetDefaultTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return SetDefaultAction::getDefaultName();
    }

    protected function setUp(): void
    {
        parent::setUp();

        SetDefaultAction::configureAction($this);
    }
}
