<?php

namespace Kolirt\Settings\Commands;

use Illuminate\Console\Command;
use Kolirt\Settings\Facades\Setting;

class FlushCacheCommand extends Command
{

    protected $signature = 'settings:flush-cache';

    protected $description = 'Flush cache';

    public function handle(): void
    {
        Setting::flushCache();
        $this->info('Cache flushed');
    }

}
