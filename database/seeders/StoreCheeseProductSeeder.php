<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoreCheesProduct;
use App\Models\Cheese;
use App\Models\User;
use App\Models\Store;

class StoreCheeseProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all stores
        $stores = \App\Models\Store::all();
        
        // Get all active cheeses
        $cheeses = \App\Models\Cheese::all();
        
        // For each store, create store_cheese_products for all cheeses
        foreach ($stores as $store) {
            foreach ($cheeses as $cheese) {
                \App\Models\StoreCheesProduct::create([
                    'store_id' => $store->id,
                    'cheese_id' => $cheese->id,
                    'status' => 'active',
                ]);
            }
        }
    }
}
