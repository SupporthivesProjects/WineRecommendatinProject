<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'business_type' => 'Retail',
                'store_name' => 'Wine Haven',
                'address' => '123 Vineyard Lane, Wine City',
                'contact_number' => '555-123-4567',
                'email' => 'info@winehaven.com',
                'state' => 'California',
                'licence_type' => 'Type 21',
                'license_number' => 'LIC12345',
                'group' => 'Premium Retailers',
                'gst_vat' => 'GST123456',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_type' => 'Wholesale',
                'store_name' => 'Grape Expectations',
                'address' => '456 Cork Road, Vintage Valley',
                'contact_number' => '555-987-6543',
                'email' => 'sales@grapeexpectations.com',
                'state' => 'Oregon',
                'licence_type' => 'Type 17',
                'license_number' => 'LIC67890',
                'group' => 'Wholesale Group',
                'gst_vat' => 'GST789012',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_type' => 'Restaurant',
                'store_name' => 'Cellar Door',
                'address' => '789 Barrel Street, Cork Town',
                'contact_number' => '555-456-7890',
                'email' => 'reservations@cellardoor.com',
                'state' => 'Washington',
                'licence_type' => 'Type 47',
                'license_number' => 'LIC24680',
                'group' => 'Fine Dining',
                'gst_vat' => 'GST345678',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
