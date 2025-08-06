<?php

namespace Database\Seeders;

use App\Models\CheeseProduct;
use Illuminate\Database\Seeder;

class CheeseProductSeeder extends Seeder
{
    public function run()
    {
        $cheeses = [
            ['name' => 'Brie', 'price' => 12.99],
            ['name' => 'Camembert', 'price' => 14.99],
            ['name' => 'Parmesan', 'price' => 18.99],
            ['name' => 'Aged Cheddar', 'price' => 15.99],
            ['name' => 'Blue Cheese', 'price' => 16.99],
            ['name' => 'Gouda', 'price' => 13.99],
            ['name' => 'Taleggio', 'price' => 17.99],
            ['name' => 'Feta', 'price' => 10.99],
            ['name' => 'Mozzarella', 'price' => 9.99],
            ['name' => 'Ricotta', 'price' => 8.99],
            ['name' => 'Goat Cheese', 'price' => 11.99],
        ];

        foreach ($cheeses as $cheese) {
            CheeseProduct::create($cheese);
        }
    }
}
