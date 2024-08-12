<?php

namespace Kolirt\Settings\Commands;

use Illuminate\Console\Command;

class PublishConfigConsoleCommand extends Command
{

    protected $signature = 'settings:publish-config';

    protected $description = 'Publish the config file';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Kolirt\\Settings\\ServiceProvider',
            '--tag' => 'config'
        ]);
    }
}
