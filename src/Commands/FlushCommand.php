<?php

namespace Kolirt\Settings\Commands;

use Illuminate\Console\Command;
use Kolirt\Settings\Facades\Setting;

class FlushCommand extends Command
{

    protected $signature = 'settings:flush';

    protected $description = 'Flush cache';

    public function handle(): void
    {
        Setting::flushCache();
        $this->info('Cache flushed');
    }

}
