# Laravel Settings 
Package for managing settings in a Laravel projects


## Structure
- [Getting started](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Setup](#setup)
  - [Compatibility with Laravel Octane](#compatibility-with-laravel-octane)
- [Methods](#methods)
  - [Set value](#set-value)
  - [Get all values](#get-all-values)
  - [Get value](#get-value)
  - [Delete value](#delete-value)
  - [Flush cache](#flush-cache)
- [Console commands](#console-commands)
- [FAQ](#faq)
- [License](#license)
- [Other packages](#other-packages)

<a href="https://www.buymeacoffee.com/kolirt" target="_blank">
  <img src="https://cdn.buymeacoffee.com/buttons/v2/arial-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;" >
</a>


## Getting started

### Requirements
- PHP >= 8.1
- Laravel >= 10

For lesser versions of Laravel or PHP, use the [v1](https://github.com/kolirt/laravel-settings/tree/v1)


### Installation
```bash
composer require kolirt/laravel-settings
```


### Setup
```bash
php artisan settings:install

php artisan migrate
```


### Compatibility with Laravel Octane
To ensure proper operation with Laravel Octane (RoadRunner or Swoole) and state synchronization across workers:
1. Use a shared cache store (e.g., 'redis') in `config/cache.php` or via `CACHE_STORE=redis` in `.env`.
2. Add `\Kolirt\Settings\Core\Setting::class` to the warm array in `config/octane.php` to initialize the singleton at worker startup:
    ```php
    'warm' => [
        \Kolirt\Settings\Core\Setting::class,
    ],
    ```
3. Add `\Kolirt\Settings\Octane\FlushSettings::class` to the `listeners[OperationTerminated::class]` array in `config/octane.php` to reset internal state after each request:
   ```php
    'listeners' => [
        OperationTerminated::class => [
            \Kolirt\Settings\Octane\FlushSettings::class,
        ]
    ],
   ```
4. Restart Octane after changes: `php artisan octane:reload`.

This ensures settings are reloaded from the shared cache or database for each request, keeping workers synchronized.



## Console commands
- `settings:install` - Install settings package
- `settings:publish-config` - Publish the config file
- `settings:publish-migrations` - Publish migration files
- `settings:flush-cache` - Flush cache


## Methods

#### `set`
The `set` method is used to set a value in the settings

```php
use Kolirt\Settings\Facades\Setting;

Setting::set('string', 'value');

Setting::set('array', [0, 1, 2]);
Setting::set('array.0', 'new value with index 0');
```


#### `all`
The `all` method is used to get all settings

```php
use Kolirt\Settings\Facades\Setting;

Setting::all();
/**
 * Returns
 * 
 * [
 *   'string' => 'value',
 *   'array' => ['new value with index 0', 1, 2]
 * ]
 */
```


#### `get`
The `get` method is used to get a value from the settings

```php
use Kolirt\Settings\Facades\Setting;

Setting::get('string'); // 'value'

Setting::get('array'); // ['new value with index 0', 1, 2]
Setting::get('array.0'); // 'new value with index 0'

// or via helper

setting('string'); // 'value'

setting('array'); // ['new value with index 0', 1, 2]
setting('array.0'); // 'new value with index 0'
```


#### `delete`
The `delete` method is used to delete a value from the settings

```php
use Kolirt\Settings\Facades\Setting;

Setting::delete('string');

Setting::delete('array'); // delete all array values
Setting::delete('array.0'); // delete array value with index 0
```


#### `flushCache`
The `flushCache` method is used to flush the cache

```php
use Kolirt\Settings\Facades\Setting;

Setting::flushCache();
```


## FAQ
Check closed [issues](https://github.com/kolirt/laravel-settings/issues) to get answers for most asked questions


## License
[MIT](LICENSE.txt)


## Other packages
Check out my other packages on my [GitHub profile](https://github.com/kolirt)
