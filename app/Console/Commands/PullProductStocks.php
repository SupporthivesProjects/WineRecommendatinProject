<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PullProductStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pull-product-stocks';

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
            ->pullProductStocks();
    
        $this->info('Product stock pulled successfully.');
    }
}
