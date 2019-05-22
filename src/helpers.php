<?php

function settings_sync(string $group, array $values)
{
    Kolirt\Settings\Models\Setting::sync($group, $values);
}

function setting(string $key, $default = null, $no_locale = false)
{
    return settings($key, $default, $no_locale);
}

function settings(string $key = null, $default = null, $no_locale = false)
{
    static $settings;

    if (is_null($settings) || $key === 'fresh') {
        $time = ($key === 'fresh') ? 0 : 24 * 60;

        $settings = Cache::remember('settings', $time, function(){
            $settings = array_map(function($arr){
                foreach ($arr as $key => $item) {
                    if (is_json($item['value'])) {
                        $arr[$key]['value'] = json_decode($item['value']);
                    }
                }
                return (object)array_pluck($arr, 'value', 'key');
            }, Kolirt\Settings\Models\Setting::all()->groupBy('group')->toArray());

            ksort($settings);

            return (object)$settings;
        });

        if ($key === 'fresh') {
            return true;
        }
    }

    if (is_null($key)) {
        return $settings;
    }

    if (is_string($key)) {
        $parts = explode('.', $key);
        $group = array_shift($parts);
        $key = array_shift($parts);

        $default = (is_array($default)) ? json_decode(json_encode($default)) : $default;

        if (count($parts)) {
            $value = $settings->$group->$key ?? $default;

            foreach ($parts as $part) {
                if (is_array($value)) {
                    $value = $value[$part] ?? $default;
                } else {
                    $value = $value->$part ?? $default;
                }
            }

            return $value;
        }

        if ($key) {
            if (!$no_locale) {
                return $settings->$group->$key->{app()->getLocale()} ?? ($settings->$group->$key ?? $default);
            } else {
                return $settings->$group->$key ?? $default;
            }
        } else {
            return $settings->$group ?? $default;
        }
    }
}