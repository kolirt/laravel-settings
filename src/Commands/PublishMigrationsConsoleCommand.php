<?php

namespace Kolirt\Settings\Commands;

use Illuminate\Console\Command;

class PublishMigrationsConsoleCommand extends Command
{

    protected $signature = 'settings:publish-migrations';

    protected $description = 'Publish migration files';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Kolirt\\Settings\\ServiceProvider',
            '--tag' => 'migrations'
        ]);
    }
}
