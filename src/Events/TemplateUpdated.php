<?php

namespace JeffersonGoncalves\FilamentMailEditor\Events;

use Illuminate\Foundation\Events\Dispatchable;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class TemplateUpdated
{
    use Dispatchable;

    public function __construct(
        public readonly EmailTemplate $template,
    ) {}
}
