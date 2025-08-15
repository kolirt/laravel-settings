<?php

namespace Kolirt\Settings;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Kolirt\Settings\Core\Setting;

class ServiceProvider extends BaseServiceProvider
{

    protected array $commands = [
        Commands\FlushCacheCommand::class,
        Commands\InstallCommand::class,
        Commands\PublishConfigConsoleCommand::class,
        Commands\PublishMigrationsConsoleCommand::class,
    ];

    public function boot(): void
    {
        $this->publishFiles();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/settings.php', 'settings');

        $this->commands($this->commands);

        $this->app->singleton(Setting::class, function () {
            return new Setting;
        });
    }

    protected function publishFiles(): void
    {
        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/settings.php' => config_path('settings.php')
        ], 'config');
    }
}
