<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturedProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('featured_products')->insert([
            [
                'product_id' => 1,
                'store_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'store_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'store_id' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
