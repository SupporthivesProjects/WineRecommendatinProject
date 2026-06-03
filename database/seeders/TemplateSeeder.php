<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        Template::firstOrCreate(
            ['name' => 'All'],
            [
                'description' => 'Contains all wine and cheese products',
                'status' => 1,
            ]
        );

        Template::firstOrCreate(
            ['name' => 'Nature\'s Basket'],
            [
                'description' => 'Nature\'s Basket template',
                'status' => 1,
            ]
        );
    }
}