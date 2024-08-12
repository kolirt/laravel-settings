<?php


if (!function_exists('array_to_object')) {
    function array_to_object($array)
    {
        if (is_array($array)) {
            return (object)array_map('array_to_object', $array);
        }
        return $array;
    }
}

if (!function_exists('array_to_collection')) {
    function array_to_collection($array)
    {
        if (is_array($array)) {
            return collect(array_map('array_to_collection', $array));
        }
        return $array;
    }
}

if (!function_exists('is_serial')) {
    function is_serial($data): bool
    {
        if (!is_string($data)) {
            return false;
        }

        return ($data === 'b:0;' || @unserialize($data) !== false);
    }
}

if (!function_exists('deep_serialize')) {
    function deep_serialize($array)
    {
        if (is_array($array)) {
            return array_map('deep_serialize', $array);
        }
        return is_object($array) ? serialize($array) : $array;
    }
}

if (!function_exists('deep_unserialize')) {
    function deep_unserialize($array)
    {
        if (is_array($array)) {
            return array_map('deep_unserialize', $array);
        }
        return is_serial($array) ? unserialize($array) : $array;
    }
}

if (!function_exists('setting')) {
    function setting(string $key_path, mixed $default = null)
    {
        return \Kolirt\Settings\Facades\Setting::get($key_path, $default);
    }
}
