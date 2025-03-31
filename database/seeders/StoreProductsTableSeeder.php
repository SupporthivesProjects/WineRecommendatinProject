<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('store_products')->insert([
            [
                'store_id' => 1,
                'product_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 1,
                'product_id' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 1,
                'product_id' => 3,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 2,
                'product_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 2,
                'product_id' => 3,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 3,
                'product_id' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
