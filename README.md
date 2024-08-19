# Laravel Settings 

## Structure
- [Getting started](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Setup](#setup)
- [Usage](#usage)
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

## Requirements
- PHP >= 8.1
- Laravel >= 10

For lesser versions of Laravel or PHP, use the [v1](https://github.com/kolirt/laravel-settings/tree/v1)


## Installation
```bash
composer require kolirt/laravel-settings
```


## Setup
```bash
php artisan settings:install

php artisan migrate
```


# Console commands
- `settings:install` - Install settings package
- `settings:publish-config` - Publish the config file
- `settings:publish-migrations` - Publish migration files
- `settings:flush-cache` - Flush cache


## Usage

### Set value
```php
use Kolirt\Settings\Facades\Setting;

Setting::set('string', 'value');

Setting::set('array', [0, 1, 2]);
Setting::set('array.0', 'new value with index 0');
```


### Get all values
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


### Get value
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


### Delete value
```php
use Kolirt\Settings\Facades\Setting;

Setting::delete('string');

Setting::delete('array'); // delete all array values
Setting::delete('array.0'); // delete array value with index 0
```


### Flush cache
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
