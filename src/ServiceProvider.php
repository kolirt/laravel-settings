<?php

namespace Kolirt\Settings;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    protected $commands = [
        Commands\InstallCommand::class
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->mergeConfigFrom(__DIR__ . '/../config/settings.php', 'settings');

        $this->publishes([
            __DIR__ . '/../config/settings.php' => config_path('settings.php')
        ]);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}