<?php

namespace Kolirt\Settings\Core;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Setting
{

    private array $data;

    public function __construct()
    {
        $this->data = Cache::remember('settings', config('settings.cache_time'), function () {
            $result = [];

            $settings = DB::connection(config('settings.connection'))->table('settings')->get();
            foreach ($settings as $setting) {
                $result[$setting->key] = deep_unserialize(json_decode($setting->value, true));
            }

            return $result;
        });
    }

    public function all()
    {
        return match (config('settings.response')) {
            'object' => array_to_object($this->data),
            'collect' => array_to_collection($this->data),
            default => $this->data
        };
    }

    public function get(string $key_path, mixed $default = null)
    {
        $result = $this->data;

        foreach (explode('.', $key_path) as $key_path) {
            if (isset($result[$key_path])) {
                $result = $result[$key_path];
            } else {
                $result = $default;
                break;
            }
        }

        return match (config('settings.response')) {
            'object' => array_to_object($result),
            'collect' => array_to_collection($result),
            default => $result
        };
    }

    public function set(string $key_path, mixed $value)
    {
        $keys = explode('.', $key_path);
        $base_key = array_shift($keys);

        if (count($keys)) {
            if (!isset($this->data[$base_key])) {
                $this->data[$base_key] = [];
            }

            $last = &$this->data[$base_key];

            foreach ($keys as $index => $key) {
                if (!is_array($last)) {
                    $last = [];
                }

                if (count($keys) - 1 === $index) {
                    $last[$key] = $value;
                } else {
                    if (!isset($last[$key])) {
                        $last = [];
                    }
                    $last = &$last[$key];
                }
            }
        } else {
            $this->data[$base_key] = $value;
        }

        $this->save($base_key);

        return match (config('settings.response')) {
            'object' => array_to_object($value),
            'collect' => array_to_collection($value),
            default => $value
        };
    }

    public function del(string $key_path): bool
    {
        $keys = explode('.', $key_path);
        $base_key = array_shift($keys);

        if (count($keys)) {
            $last = &$this->data[$base_key];

            foreach ($keys as $index => $key) {
                if (count($keys) - 1 === $index) {
                    unset($last[$key]);
                } else {
                    if (isset($last[$key])) {
                        $last = &$last[$key];
                    } else {
                        return true;
                    }
                }
            }

            return $this->save($base_key);
        } else {
            DB::connection(config('settings.connection'))
                ->table('settings')
                ->where('key', $base_key)
                ->delete();

            unset($this->data[$base_key]);

            return true;
        }
    }

    public function flushCache(): bool
    {
        Cache::forget('settings');
        return true;
    }

    private function save(string $key): bool
    {
        DB::connection(config('settings.connection'))
            ->table('settings')
            ->updateOrInsert(
                ['key' => $key],
                ['value' => json_encode(deep_serialize($this->data[$key]))]
            );

        return $this->flushCache();
    }

}
