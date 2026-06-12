<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CartCheckout;
use App\Models\CheckoutItem;
use App\Models\Product;

class BackfillCheckoutItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backfill-checkout-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill historical checkout records into checkout_items table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $checkouts = CartCheckout::all();
    
        foreach ($checkouts as $checkout) {
    
            $products = json_decode($checkout->products, true);
    
            if (!$products || !is_array($products)) {
                continue;
            }
    
            foreach ($products as $item) {
    
                $exists = CheckoutItem::where('checkout_id', $checkout->id)
                    ->where('product_id', $item['id'])
                    ->first();
    
                if ($exists) {
                    continue;
                }
    
                $product = Product::find($item['id']);
                $productName = $item['name']
                    ?? $product->wine_name
                    ?? 'Unknown Product';

                CheckoutItem::create([
                    'checkout_id'      => $checkout->id,
                    'product_id'       => $item['id'],
                    'user_id'          => $checkout->user_id,
                    'store_manager_id' => $checkout->store_manager_id,
                    'product_name'     => $productName,
                    'price'            => $item['retail_price'] ?? 0,
                    'quantity'         => $item['quantity'] ?? 1,
                    'created_at'       => $checkout->created_at,
                    'updated_at'       => $checkout->updated_at,
                ]);
            }
        }
    
        $this->info('Checkout items backfilled successfully.');
    }
}
