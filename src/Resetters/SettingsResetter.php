<?php

namespace Kolirt\Settings\Resetters;

use Closure;
use Kolirt\Settings\Core\Setting;
use Laravel\Octane\Contracts\OperationTerminated;

class SettingsResetter implements OperationTerminated
{
    public function terminate(array $serverState): Closure
    {
        return function ($sandbox) {
            /** @var Setting $setting */
            $setting = $sandbox->app->make(Setting::class);
            $setting->reset();
            return $sandbox;
        };
    }
}
