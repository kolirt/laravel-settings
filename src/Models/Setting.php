<?php

namespace Kolirt\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'group',
        'key',
        'value',
    ];

    public static function sync(string $group, array $values)
    {
        foreach ($values as $key => $value) {
            Setting::where('group', $group)->where('key', $key)->update(['value' => json_encode($value)]);
        }

        setting('fresh');
    }

}
