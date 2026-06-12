<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StoreManagerUpload;
use App\Models\CheckoutItem;

class BackfillStoreManagerUploads extends Command
{
    protected $signature = 'app:backfill-store-manager-uploads';

    protected $description = 'Move historical store manager uploads into checkout_items';

    public function handle()
    {
        $count = 0;

        StoreManagerUpload::chunk(500, function ($uploads) use (&$count) {

            foreach ($uploads as $upload) {

                $exists = CheckoutItem::where(
                    'store_manager_id',
                    $upload->store_manager_id
                )
                ->where(
                    'product_name',
                    $upload->product_name
                )
                ->where(
                    'price',
                    $upload->product_price
                )
                ->whereDate(
                    'created_at',
                    $upload->date
                )
                ->first();

                if ($exists) {
                    continue;
                }

                CheckoutItem::create([

                    'checkout_id' => null,

                    'product_id' => null,

                    'user_id' => null,

                    'store_manager_id' =>
                        $upload->store_manager_id,

                    'product_name' =>
                        $upload->product_name,

                    'price' =>
                        $upload->product_price,

                    'quantity' =>
                        $upload->qty ?: 1,

                    'created_at' =>
                        $upload->date
                            ? \Carbon\Carbon::parse($upload->date)
                            : now(),

                    'updated_at' => now()
                ]);

                $count++;
            }
        });

        $this->info(
            "Backfilled {$count} records successfully."
        );

        return Command::SUCCESS;
    }
}