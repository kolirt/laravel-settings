<?php

namespace Kolirt\Settings\Octane;

use Kolirt\Settings\Core\Setting;

class FlushSettings
{
    public function handle($event)
    {
        /** @var Setting $settings */
        $settings = app(Setting::class);
        $settings->reset();
    }
}
