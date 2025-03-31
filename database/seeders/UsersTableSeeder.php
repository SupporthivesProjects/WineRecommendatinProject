<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'mobile' => '555-111-2222',
                'store_id' => null,
                'email' => 'admin@winerecommender.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Manager',
                'mobile' => '555-333-4444',
                'store_id' => 1,
                'email' => 'john@winehaven.com',
                'password' => Hash::make('password'),
                'role' => 'store_manager',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Manager',
                'mobile' => '555-555-6666',
                'store_id' => 2,
                'email' => 'sarah@grapeexpectations.com',
                'password' => Hash::make('password'),
                'role' => 'store_manager',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
