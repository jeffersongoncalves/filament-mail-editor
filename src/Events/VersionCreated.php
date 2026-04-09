<?php

namespace JeffersonGoncalves\FilamentMailEditor\Events;

use Illuminate\Foundation\Events\Dispatchable;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplateVersion;

class VersionCreated
{
    use Dispatchable;

    public function __construct(
        public readonly EmailTemplateVersion $version,
    ) {}
}
