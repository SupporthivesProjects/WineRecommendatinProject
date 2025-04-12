<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StoresTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            StoreProductsTableSeeder::class,
            FeaturedProductsTableSeeder::class,
            SelectedProductsTableSeeder::class,
            QuestionnaireTableSeeder::class,
            QuestionnaireTemplateSeeder::class,
        ]);
    }
}
