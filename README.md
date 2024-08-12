# Laravel Settings 

# Structure
- [Getting started](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Setup](#setup)
- [Console commands](#console-commands)
- [FAQ](#faq)
- [License](#license)
- [Other packages](#other-packages)

<a href="https://www.buymeacoffee.com/kolirt" target="_blank">
  <img src="https://cdn.buymeacoffee.com/buttons/v2/arial-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;" >
</a>


# Getting started

## Requirements
- PHP >= 8.1
- Laravel >= 10


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
- `settings:flush` - Flush cache


# FAQ
Check closed [issues](#) to get answers for most asked questions


# License
[MIT](LICENSE.txt)

# Other packages
Check out my other packages on my [GitHub profile](https://github.com/kolirt)
