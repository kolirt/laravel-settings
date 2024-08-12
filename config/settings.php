<?php

return [
    'connection' => env('SETTINGS_CONNECTION', config('database.default', 'mysql')),

    'cache_time' => 24 * 60, // minutes

    'response' => 'array', // array, object, collect
];
