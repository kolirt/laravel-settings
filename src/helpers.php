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
            $no_locale = !config('settings.auto_locale', false);
        }

        static $settings;

        if ($key === 'fresh') {
            Cache::forget('settings');
            $settings = null;
            return true;
        }

        if (is_null($settings)) {
            $time = 24 * 60;

            $settings = Cache::remember('settings', $time, function () {
                $result = [];

                foreach (Kolirt\Settings\Models\Setting::all()->groupBy('group') as $group => $item) {
                    foreach ($item as $setting) {
                        $result[$group][$setting->key] = $setting->value;
                    }
                }

                return $result;
            });
        }

        $result = $settings;

        if (!is_null($key)) {
            foreach (explode('.', $key) as $key) {
                if (isset($result[$key])) {
                    $result = $result[$key];
                } else {
                    $result = $default;
                    break;
                }
            }
        }

        if (!$no_locale) {
            if (isset($result[app()->getLocale()])) {
                $result = $result[app()->getLocale()];
            }
        }

        if (config('settings.response', 'object') === 'array') {
            return $result;
        } else if (config('settings.response', 'object') === 'object') {
            return json_decode(json_encode($result));
        } else if (config('settings.response', 'object') === 'collect') {
            return collect($result);
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
