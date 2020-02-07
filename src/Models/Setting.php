<?php

namespace Kolirt\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $timestamps = false;

    protected $fillable = ['group', 'key', 'value'];

    protected $casts = [
        'value' => 'json'
    ];

}
