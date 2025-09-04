<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoreCheesProduct;
use App\Models\Store;
use App\Models\Cheese;

class StoreCheseProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all stores and cheeses
        $stores = Store::all();
        $cheeses = Cheese::all();

        if ($stores->isEmpty() || $cheeses->isEmpty()) {
            $this->command->info('No stores or cheeses found. Make sure to run StoreSeeder and CheeseSeeder first.');
            return;
        }

        // For each store, assign random cheeses
        foreach ($stores as $store) {
            // Randomly select 60-80% of available cheeses for each store
            $cheeseCount = $cheeses->count();
            $assignCount = rand(ceil($cheeseCount * 0.6), ceil($cheeseCount * 0.8));
            
            $selectedCheeses = $cheeses->random($assignCount);

            foreach ($selectedCheeses as $cheese) {
                // Random status: 80% active, 20% inactive
                $status = (rand(1, 100) <= 80) ? 'active' : 'inactive';

                StoreCheesProduct::create([
                    'store_id' => $store->id,
                    'cheese_id' => $cheese->id,
                    'status' => $status,
                ]);
            }
        }

        $this->command->info('Store cheese products seeded successfully!');
    }
}
