<?php

namespace JeffersonGoncalves\FilamentMailEditor\Events;

use Illuminate\Foundation\Events\Dispatchable;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class TemplateStatusChanged
{
    use Dispatchable;

    public function __construct(
        public readonly EmailTemplate $template,
        public readonly TemplateStatus $oldStatus,
        public readonly TemplateStatus $newStatus,
    ) {}
}
