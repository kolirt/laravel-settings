<?php

if (!function_exists('settings_sync')) {
    function settings_sync(string $group, array $values)
    {
        Kolirt\Settings\Models\Setting::sync($group, $values);
    }
}

if (!function_exists('setting')) {
    function setting($key = null, $default = null, $no_locale = null)
    {
        if (is_array($key)) {
            dd('store', $key);
        }

        if (!is_null($key)) {
            return \Kolirt\Settings\Facade\Setting::get($key, $default, $no_locale);
        }

        return \Kolirt\Settings\Facade\Setting::getFacadeRoot();
    }
}

if (!function_exists('is_json')) {
    function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
