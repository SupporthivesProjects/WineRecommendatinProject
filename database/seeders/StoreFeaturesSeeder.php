<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Feature;
use App\Models\StoreFeature;

class StoreFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::all();
        $features = Feature::where('status', 1)->get();

        foreach ($stores as $store) {
            foreach ($features as $feature) {

                StoreFeature::firstOrCreate(
                    [
                        'store_id' => $store->id,
                        'feature_id' => $feature->id,
                    ],
                    [
                        'enabled' => 0,
                    ]
                );

            }
        }
    }


}
