<?php

namespace JeffersonGoncalves\FilamentMailEditor\Events;

use Illuminate\Foundation\Events\Dispatchable;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class TestEmailSent
{
    use Dispatchable;

    public function __construct(
        public readonly EmailTemplate $template,
        public readonly string $address,
    ) {}
}
