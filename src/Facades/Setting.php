<?php

namespace Kolirt\Settings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Kolirt\Settings\Core\Setting
 */
class Setting extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return \Kolirt\Settings\Core\Setting::class;
    }

}
