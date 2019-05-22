# Laravel Settings 

## Installation
```
$ composer require kolirt/laravel-settings
```
```
$ php artisan migrate
```

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
(object)[
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
(object)[
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

(object)[
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

(object)[
    'test' => 'test'
];
```

### Refresh cache
```
setting('fresh');
```