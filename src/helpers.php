<?php

if (!function_exists('settings_sync')) {
    function settings_sync(string $group, array $values)
    {
        Kolirt\Settings\Models\Setting::sync($group, $values);
    }
}

if (!function_exists('setting')) {
    function setting(string $key, $default = null, $no_locale = null)
    {
        return settings($key, $default, $no_locale);
    }
}

if (!function_exists('settings')) {
    function settings(string $key = null, $default = null, $no_locale = null)
    {
        if (is_null($no_locale)) {
            $no_locale = !setting('settings.auto_locale', false);
        }

        static $settings;

        if (is_null($settings) || $key === 'fresh') {
            $time = ($key === 'fresh') ? 0 : 24 * 60;

            $settings = Cache::remember('settings', $time, function(){
                $settings = [];

                foreach (Kolirt\Settings\Models\Setting::all()->groupBy('group') as $group => $item) {
                    foreach ($item as $setting) {
                        $settings[$group][$setting->key] = $setting->value;
                    }
                }

                return $settings;
            });

            if ($key === 'fresh') {
                return true;
            }
        }

        if (is_null($key)) {
            return json_decode(json_encode($settings));
        }

        foreach (explode('.', $key) as $key) {
            if (isset($settings[$key])) {
                $settings = $settings[$key];
            } else {
                $settings = $default;
                break;
            }
        }

        if (!$no_locale) {
            if (isset($settings[app()->getLocale()])) {
                return json_decode(json_encode($settings[app()->getLocale()]));
            } else {
                return json_decode(json_encode($default));
            }
        }

        if (setting('settings.response', 'object') === 'array') {
            return $settings;
        } else if (setting('settings.response', 'object') === 'object') {
            return json_decode(json_encode($settings));
        } else if (setting('settings.response', 'object') === 'collect') {
            return collect($settings);
        }
    }
}

if (!function_exists('is_json')) {
    function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}