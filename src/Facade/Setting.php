<?php

namespace Kolirt\Settings\Facade;

use \Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Class Setting
 * @package Kolirt\Settings\Facade
 * @method \Kolirt\Settings\Setting getFacadeRoot
 */
class Setting extends BaseFacade
{

    protected static function getFacadeAccessor()
    {
        return 'settings';
    }

}
