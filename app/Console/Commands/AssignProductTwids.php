<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AssignProductTwids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-product-twids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign sequential TWIDs to existing products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::whereNull('twid')
            ->orderBy('id', 'asc')
            ->get();

        if ($products->isEmpty()) {
            $this->info('All products already have TWIDs.');
            return Command::SUCCESS;
        }

        foreach ($products as $product) {
            DB::transaction(function () use ($product) {
                $sequence = DB::table('twid_sequences')
                    ->where('id', 1)
                    ->lockForUpdate()
                    ->first();

                $nextNumber = $sequence->last_number + 1;

                $twid = 'TW' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

                DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'twid' => $twid,
                    'updated_at' => now(),
                ]);

                DB::table('twid_sequences')
                    ->where('id', 1)
                    ->update([
                        'last_number' => $nextNumber,
                        'updated_at' => now(),
                    ]);

                $this->info(
                    "Product ID {$product->id} assigned TWID: {$twid}"
                );
            });
        }

        $this->info('TWID assignment completed.');

        return Command::SUCCESS;
    }
}