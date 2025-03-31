<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectedProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('selected_products')->insert([
            [
                'product_id' => 1,
                'store_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'store_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'store_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
