<?php

namespace JeffersonGoncalves\FilamentMailEditor\Events;

use Illuminate\Foundation\Events\Dispatchable;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplateVersion;

class VersionRestored
{
    use Dispatchable;

    public function __construct(
        public readonly EmailTemplate $template,
        public readonly EmailTemplateVersion $version,
    ) {}
}
