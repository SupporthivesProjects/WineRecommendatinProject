<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PullProductMasters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pull-product-masters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(\App\Services\T3ApiService::class)
            ->pullProductMasters();
    
        $this->info('Product master pulled successfully.');
    }
}
