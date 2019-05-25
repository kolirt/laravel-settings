<?php

namespace Kolirt\Settings\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install settings package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => 'Kolirt\\Settings\\ServiceProvider']);
        $this->call('migrate');
    }
}
