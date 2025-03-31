<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questionnaire')->insert([
            [
                'product_id' => 1,
                'q1' => 'Red',
                'q2' => 'Full-bodied',
                'q3' => 'Dry',
                'q4' => 'Aged',
                'q5' => 'Premium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'q1' => 'White',
                'q2' => 'Light-bodied',
                'q3' => 'Crisp',
                'q4' => 'Fresh',
                'q5' => 'Mid-range',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'q1' => 'Sparkling',
                'q2' => 'Medium-bodied',
                'q3' => 'Brut',
                'q4' => 'Celebratory',
                'q5' => 'Luxury',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
