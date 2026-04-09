<?php

namespace JeffersonGoncalves\FilamentMailEditor\Events;

use Illuminate\Foundation\Events\Dispatchable;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class TemplateUnlocked
{
    use Dispatchable;

    public function __construct(
        public readonly EmailTemplate $template,
    ) {}
}
