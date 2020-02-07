<?php

namespace Kolirt\Settings;

use Illuminate\Support\Arr;
use Kolirt\Settings\Models\Setting as SettingModel;
use Cache;

class Setting
{

    protected $items;

    public function __construct()
    {
        $this->getSettings();
    }

    public function get(string $key, $default = null, $no_locale = null)
    {
        $result = $this->items;

        foreach (explode('.', $key) as $key) {
            if (isset($result[$key])) {
                $result = $result[$key];
            } else {
                $result = $default;
                break;
            }
        }

        return $this->prepare($result, $no_locale);
    }

    public function set($group, $key, $value = null)
    {
        dd('set', $group, $key, $value);
    }

    public function sync($group, $key, $value = null)
    {
        dd('sync', $group, $key, $value);
    }

    public function forget(string $key): void
    {
        $result = $this->items;
        Arr::forget($result, $key);

    }

    public function all($no_locale = null)
    {
        return $this->prepare($this->items, $no_locale);
    }

    public function has(string $key)
    {
        return false;
    }

    private function save($group, $key = null, $value = null)
    {
        try {
            DB::beginTransaction();

            if (is_array($group)) {
                dd($group);
            } else if (is_array($key)) {
                foreach ($key as $k => $item) {
                    $setting = SettingModel::firstOrNew(['group' => $group, 'key' => $k]);
                    $setting->value = $item;
                    $setting->save();
                }
            } else {
                $setting = SettingModel::firstOrNew(['group' => $group, 'key' => $key]);
                $setting->value = $value;
                $setting->save();
            }

            DB::commit();
            $this->getSettings(true);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    private function getSettings($fresh = false): void
    {
        static $settings;

        if (is_null($settings) || $fresh) {
            $time = 24 * 60;

            $settings = Cache::remember('laravel-settings', $time, function () {
                $result = [];

                foreach (SettingModel::all()->groupBy('group') as $group => $item) {
                    foreach ($item as $setting) {
                        $result[$group][$setting->key] = $setting->value;
                    }
                }

                return $result;
            });
        }

        $this->items = $settings;
    }

    private function freshSettings()
    {
        if ($key === 'fresh') {
            Cache::forget('laravel-settings');
            if ($key === 'fresh') {
                return true;
            }
        }
    }

    private function prepare($result, $no_locale = null)
    {
        if (is_null($no_locale)) {
            $no_locale = !config('settings.auto_locale', true);
        }

        if (!$no_locale) {
            if (isset($result[app()->getLocale()])) {
                $result = $result[app()->getLocale()];
            }
        }

        if (config('settings.response', 'object') === 'array') {
            return $result;
        } else if (config('settings.response', 'object') === 'object') {
            return is_array($result) ? json_decode(json_encode($result)) : $result;
        } else if (config('settings.response', 'object') === 'collect') {
            return is_array($result) ? collect($result) : $result;
        }
    }

}
