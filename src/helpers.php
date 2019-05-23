<?php

if (!function_exists('settings_sync')) {
    function settings_sync(string $group, array $values)
    {
        Kolirt\Settings\Models\Setting::sync($group, $values);
    }
}

if (!function_exists('setting')) {
    function setting(string $key, $default = null, $no_locale = true)
    {
        return settings($key, $default, $no_locale);
    }
}

if (!function_exists('settings')) {
    function settings(string $key = null, $default = null, $no_locale = true)
    {
        static $settings;

        if (is_null($settings) || $key === 'fresh') {
            $time = ($key === 'fresh') ? 0 : 24 * 60;

            $settings = Cache::remember('settings', $time, function(){
                $result = [];

                foreach (Kolirt\Settings\Models\Setting::all()->groupBy('group') as $group => $item) {
                    foreach ($item as $setting) {
                        $result[$group][$setting->key] = $setting->value;
                    }
                }

                return $result;
            });

            if ($key === 'fresh') {
                return true;
            }
        }

        if (is_null($key)) {
            return json_decode(json_encode($settings));
        }

        $result = $settings;
        
        foreach (explode('.', $key) as $key) {
            if (isset($result[$key])) {
                $result = $result[$key];
            } else {
                $result = $default;
                break;
            }
        }

        if (!$no_locale) {
            if (isset($result[app()->getLocale()])) {
                return json_decode(json_encode($result[app()->getLocale()]));
            } else {
                return json_decode(json_encode($result));
            }
        }

        return json_decode(json_encode($result));
    }
}

if (!function_exists('is_json')) {
    function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
