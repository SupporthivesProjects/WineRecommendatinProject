<?php

namespace Database\Seeders;

use App\Models\CheeseProduct;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreInventorySeeder extends Seeder
{
    public function run()
    {
        // Get all stores and cheese products
        $stores = Store::all();
        $cheeseProducts = CheeseProduct::all();

        foreach ($stores as $store) {
            foreach ($cheeseProducts as $cheese) {
                // Random quantity between 10-100
                $quantity = rand(10, 100);
                // 90% chance of being active
                $isActive = rand(1, 10) <= 9;

                $store->cheeseProducts()->attach($cheese->id, [
                    'quantity' => $quantity,
                    'is_available' => $isActive,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
