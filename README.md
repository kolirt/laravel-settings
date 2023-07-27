# Laravel Settings 
Package tested with Laravel 5.8. Other versions are not tested.

| Laravel version  | Tested  |
| ---------------- | ------- |
| 5.8.*            | ✅      |

## Installation
```
$ composer require kolirt/laravel-settings
```
```
$ php artisan settings:install
```
Configure translations config on config/settings.php path.

## Methods

#### Sync data (settings_sync)
```
$data = [
    'key1' => [
        'subkey1' => [
            'subsubnkey1' => 1,
            'subsubnkey2' => [
                'test' => 'test'
            ]
        ],
        'subkey2' => 2
    ],
    'key2' => []
];

settings_sync('group', $data);

$data = [
    'key' => 1
];

settings_sync('group1', $data);
```

#### Get all (settings)
```
settings();

// result
[
    'group' => [
        'key1' => [
            'subkey1' => [
                'subsubnkey1' => 1,
                'subsubnkey2' => [
                    'test' => 'test'
                ]
            ],
            'subkey2' => 2
        ],
        'key2' => []
    ],
    'group1' => [
        'key' => 1
    ]
];
```

#### Get by group name (setting)
```
setting('group');

// result
[
    'key1' => [
        'subkey1' => [
            'subsubnkey1' => 1,
            'subsubnkey2' => [
                'test' => 'test'
            ]
        ],
        'subkey2' => 2
    ],
    'key2' => []
];
```

#### Get by group name and key (setting)
```
setting('group.key1');

// result

[
    'subkey1' => [
        'subsubnkey1' => 1,
        'subsubnkey2' => [
            'test' => 'test'
        ]
    ],
    'subkey2' => 2
];
```

#### Parse (setting)
```
setting('group.key1.subkey1.subsubnkey2');

// result

[
    'test' => 'test'
];
```

### Refresh cache
```
setting('fresh');
```