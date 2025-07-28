<?php

namespace Database\Seeders;

use App\Models\CheeseProduct;
use Illuminate\Database\Seeder;

class CheesePairingSeeder extends Seeder
{
    public function run()
    {
        $pairings = [
            ['name' => 'Brie, Camembert'],
            ['name' => 'Parmesan, Aged Cheddar, Blue Cheese'],
            ['name' => 'Gouda, Blue Cheese, Aged Cheddar'],
            ['name' => 'Brie, Camembert and Aged Cheddar'],
            ['name' => 'Aged Cheddar, Blue Cheese, Taleggio'],
            ['name' => 'Feta, Mozzarella, Ricotta, Goat Cheese']
        ];

        foreach ($pairings as $pairing) {
            \App\Models\CheesePairing::create($pairing);
        }
    }
}
