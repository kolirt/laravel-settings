<?php

namespace Kolirt\Settings\Listeners;

use Kolirt\Settings\Core\Setting;

class ResetSettingsAfterJob
{
    public function handle($event)
    {
        /** @var Setting $settings */
        $settings = app(Setting::class);
        $settings->reset();
    }
}
