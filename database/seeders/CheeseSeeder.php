<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cheese;

class CheeseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cheeses = [
            [
                'name' => 'Brie',
                'description' => 'A soft cow\'s-milk cheese with a white, bloomy rind and creamy interior.',
                'type' => 'soft',
                'texture' => 'creamy',
                'origin_country' => 'France',
                'milk_type' => 'cow',
                'fat_content' => 28.00,
                'flavor_profile' => 'Mild, buttery, nutty with earthy undertones',
                'aging_period' => '4-5 weeks',
                'status' => true,
            ],
            [
                'name' => 'Camembert',
                'description' => 'A soft-ripened cow\'s milk cheese with a white, bloomy rind.',
                'type' => 'soft',
                'texture' => 'creamy',
                'origin_country' => 'France',
                'milk_type' => 'cow',
                'fat_content' => 24.00,
                'flavor_profile' => 'Rich, creamy, earthy, mushroom-like',
                'aging_period' => '3-4 weeks',
                'status' => true,
            ],
            [
                'name' => 'Parmesan',
                'description' => 'A hard, granular cheese with a sharp, complex flavor.',
                'type' => 'hard',
                'texture' => 'granular',
                'origin_country' => 'Italy',
                'milk_type' => 'cow',
                'fat_content' => 32.00,
                'flavor_profile' => 'Sharp, nutty, fruity, complex',
                'aging_period' => '12-36 months',
                'status' => true,
            ],
            [
                'name' => 'Aged Cheddar',
                'description' => 'A firm cheese with a sharp, tangy flavor that intensifies with age.',
                'type' => 'hard',
                'texture' => 'firm',
                'origin_country' => 'England',
                'milk_type' => 'cow',
                'fat_content' => 33.00,
                'flavor_profile' => 'Sharp, tangy, nutty, complex',
                'aging_period' => '12+ months',
                'status' => true,
            ],
            [
                'name' => 'Blue Cheese',
                'description' => 'A cheese with blue-green veins of mold and a strong, pungent flavor.',
                'type' => 'blue',
                'texture' => 'creamy',
                'origin_country' => 'France',
                'milk_type' => 'cow',
                'fat_content' => 28.00,
                'flavor_profile' => 'Strong, pungent, salty, tangy',
                'aging_period' => '2-3 months',
                'status' => true,
            ],
            [
                'name' => 'Gouda',
                'description' => 'A Dutch cheese with a smooth texture and sweet, nutty flavor.',
                'type' => 'semi-hard',
                'texture' => 'smooth',
                'origin_country' => 'Netherlands',
                'milk_type' => 'cow',
                'fat_content' => 28.00,
                'flavor_profile' => 'Sweet, nutty, caramel notes when aged',
                'aging_period' => '1-36 months',
                'status' => true,
            ],
            [
                'name' => 'Taleggio',
                'description' => 'An Italian semi-soft cheese with a washed rind and pungent aroma.',
                'type' => 'semi-soft',
                'texture' => 'creamy',
                'origin_country' => 'Italy',
                'milk_type' => 'cow',
                'fat_content' => 26.00,
                'flavor_profile' => 'Mild, fruity, slightly tangy with meaty undertones',
                'aging_period' => '6-10 weeks',
                'status' => true,
            ],
            [
                'name' => 'Feta',
                'description' => 'A brined curd cheese with a tangy, salty flavor.',
                'type' => 'soft',
                'texture' => 'crumbly',
                'origin_country' => 'Greece',
                'milk_type' => 'sheep',
                'fat_content' => 21.00,
                'flavor_profile' => 'Tangy, salty, sharp',
                'aging_period' => '2 months',
                'status' => true,
            ],
            [
                'name' => 'Mozzarella',
                'description' => 'A soft Italian cheese with a mild, milky flavor.',
                'type' => 'soft',
                'texture' => 'elastic',
                'origin_country' => 'Italy',
                'milk_type' => 'cow',
                'fat_content' => 22.00,
                'flavor_profile' => 'Mild, milky, fresh',
                'aging_period' => 'Fresh (1-3 days)',
                'status' => true,
            ],
            [
                'name' => 'Ricotta',
                'description' => 'A fresh Italian cheese with a light, creamy texture.',
                'type' => 'soft',
                'texture' => 'light and creamy',
                'origin_country' => 'Italy',
                'milk_type' => 'cow',
                'fat_content' => 13.00,
                'flavor_profile' => 'Mild, sweet, slightly grainy',
                'aging_period' => 'Fresh (1-5 days)',
                'status' => true,
            ],
            [
                'name' => 'Goat Cheese',
                'description' => 'A tangy cheese made from goat\'s milk with a distinctive flavor.',
                'type' => 'soft',
                'texture' => 'creamy',
                'origin_country' => 'France',
                'milk_type' => 'goat',
                'fat_content' => 25.00,
                'flavor_profile' => 'Tangy, earthy, slightly sweet',
                'aging_period' => '2-4 weeks',
                'status' => true,
            ],
        ];

        foreach ($cheeses as $cheese) {
            Cheese::create($cheese);
        }
    }
}
