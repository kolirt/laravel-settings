<?php

namespace Kolirt\Settings\Resetters;

use Kolirt\Settings\Core\Setting;

class SettingsResetter
{
    public function handle($event)
    {
        /** @var Setting $settings */
        $settings = app(Setting::class);
        $settings->reset();
    }
}
