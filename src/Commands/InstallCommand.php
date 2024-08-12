<?php

namespace Kolirt\Settings\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{

    protected $signature = 'settings:install';

    protected $description = 'Install settings package';

    public function handle(): void
    {
        $this->call(PublishConfigConsoleCommand::class);
        $this->call(PublishMigrationsConsoleCommand::class);
    }

}
