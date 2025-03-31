<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'wine_name' => 'Château Margaux 2015',
                'type' => 'Red',
                'grape_variety' => 'Cabernet Sauvignon',
                'varietal_blend' => 'Blend',
                'vintage_year' => '2015',
                'wine_sub_region' => 'Margaux',
                'winery' => 'Château Margaux',
                'alcohol_vol' => '13.5%',
                'body' => 'Full',
                'tannin_level' => 'High',
                'acidity' => 'Medium',
                'aroma' => 'Black fruit, cedar, tobacco',
                'palate' => 'Rich, complex with dark fruit and spice notes',
                'finish' => 'Long, elegant',
                'retail_price' => 899.99,
                'country' => 'France',
                'image1' => 'chateau_margaux_2015.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'wine_name' => 'Cloudy Bay Sauvignon Blanc 2022',
                'type' => 'White',
                'grape_variety' => 'Sauvignon Blanc',
                'varietal_blend' => 'Single Varietal',
                'vintage_year' => '2022',
                'wine_sub_region' => 'Marlborough',
                'winery' => 'Cloudy Bay',
                'alcohol_vol' => '13%',
                'body' => 'Medium',
                'tannin_level' => 'None',
                'acidity' => 'High',
                'aroma' => 'Citrus, passionfruit, fresh herbs',
                'palate' => 'Vibrant with grapefruit and tropical fruit notes',
                'finish' => 'Crisp, refreshing',
                'retail_price' => 34.99,
                'country' => 'New Zealand',
                'image1' => 'cloudy_bay_sb_2022.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'wine_name' => 'Dom Pérignon 2012',
                'type' => 'Sparkling',
                'grape_variety' => 'Chardonnay, Pinot Noir',
                'varietal_blend' => 'Blend',
                'vintage_year' => '2012',
                'wine_sub_region' => 'Champagne',
                'winery' => 'Dom Pérignon',
                'alcohol_vol' => '12.5%',
                'body' => 'Medium',
                'tannin_level' => 'None',
                'acidity' => 'High',
                'aroma' => 'Brioche, almond, white flowers',
                'palate' => 'Elegant with citrus, peach and toasty notes',
                'finish' => 'Long, mineral-driven',
                'retail_price' => 199.99,
                'country' => 'France',
                'image1' => 'dom_perignon_2012.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
