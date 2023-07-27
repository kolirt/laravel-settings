<?php

namespace Kolirt\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $timestamps = false;

    protected $fillable = ['group', 'key', 'value'];

    public function __construct(array $attributes = [])
    {
        $this->setConnection(config('settings.connection'));
        parent::__construct($attributes);
    }

    public static function sync(string $group, array $values)
    {
        foreach ($values as $key => $value) {
            $setting = Setting::firstOrNew(['group' => $group, 'key' => $key]);
            $setting->value = json_encode($value);
            $setting->save();
        }

        setting('fresh');
    }

    public function getValueAttribute($value)
    {
        return is_json($value) ? json_decode($value, 1) : $value;
    }

}
