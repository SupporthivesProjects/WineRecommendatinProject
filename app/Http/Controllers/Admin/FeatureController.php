<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Store;

use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::all();

        return view('admin.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     try {

    //         $validated = $request->validate([
    //             'name' => 'required|string|max:255',
    //             'key' => 'required|string|max:255|unique:features,key',
    //             'description' => 'nullable|string',
    //             'status' => 'required|boolean',
    //             'user_type' => 'required|in:manager,parent,both',
    //         ]);

    //         $feature = Feature::create($validated);

    //         $rows = [];

    //         foreach (Store::pluck('id') as $storeId) {
    //             $rows[] = [
    //                 'store_id' => $storeId,
    //                 'feature_id' => $feature->id,
    //                 'enabled' => 0,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }

    //         DB::table('store_features')->insert($rows);

    //         return redirect()
    //             ->route('admin.features.index')
    //             ->with('success', 'Feature created successfully.');

    //     } catch (\Exception $e) {

    //         return redirect()
    //             ->back()
    //             ->withInput()
    //             ->with('error', $e->getMessage());
    //     }
    // }
    public function store(Request $request)
    {

        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'key' => 'required|string|max:255|unique:features,key',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
                'user_type' => 'required|in:manager,parent,both',
            ]);

            $feature = Feature::create($validated);

            /*
            |--------------------------------------------------------------------------
            | Assign Feature to Stores
            |--------------------------------------------------------------------------
            */

            // Store Manager Features
            if (in_array($feature->user_type, ['manager', 'both'])) {

                $managerRows = [];

                foreach (Store::pluck('id') as $storeId) {
                    $managerRows[] = [
                        'store_id' => $storeId,
                        'feature_id' => $feature->id,
                        'enabled' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($managerRows)) {
                    DB::table('store_features')->insert($managerRows);
                }
            }

            // Store Parent Features
            if (in_array($feature->user_type, ['parent', 'both'])) {

                $parentRows = [];

                foreach (Store::pluck('id') as $storeId) {
                    $parentRows[] = [
                        'store_id' => $storeId,
                        'feature_id' => $feature->id,
                        'enabled' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($parentRows)) {
                    DB::table('store_parent_features')->insert($parentRows);
                }
            }

            return redirect()
                ->route('admin.features.index')
                ->with('success', 'Feature created successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.features.show', compact('feature'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'key' => 'required|string|max:255',
    //         'status' => 'required|boolean',
    //         'user_type' => 'required|in:manager,parent,both',
    //     ]);
    
    //     try {
    
    //         $feature = Feature::findOrFail($id);
    
    //         $feature->update([
    //             'name'        => $request->name,
    //             'description' => $request->description,
    //             'key'         => $request->key,
    //             'status'      => $request->status,
    //             'user_type'   => $request->user_type,
    //         ]);
    
    //         return redirect()
    //             ->route('admin.features.index')
    //             ->with('success', 'Feature updated successfully.');
    
    //     } catch (\Exception $e) {
    
    //         return redirect()
    //             ->back()
    //             ->withInput()
    //             ->with('error', $e->getMessage());
    //     }
    // }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'key' => 'required|string|max:255',
            'status' => 'required|boolean',
            'user_type' => 'required|in:manager,parent,both',
        ]);

        try {

            $feature = Feature::findOrFail($id);

            $feature->update([
                'name'        => $request->name,
                'description' => $request->description,
                'key'         => $request->key,
                'status'      => $request->status,
                'user_type'   => $request->user_type,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Add Store Manager Feature Assignments
            |--------------------------------------------------------------------------
            */

            if (in_array($feature->user_type, ['manager', 'both'])) {

                $managerRows = [];

                foreach (Store::pluck('id') as $storeId) {
                    $managerRows[] = [
                        'store_id' => $storeId,
                        'feature_id' => $feature->id,
                        'enabled' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($managerRows)) {
                    DB::table('store_features')->insertOrIgnore($managerRows);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Add Store Parent Feature Assignments
            |--------------------------------------------------------------------------
            */

            if (in_array($feature->user_type, ['parent', 'both'])) {

                $parentRows = [];

                foreach (Store::pluck('id') as $storeId) {
                    $parentRows[] = [
                        'store_id' => $storeId,
                        'feature_id' => $feature->id,
                        'enabled' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($parentRows)) {
                    DB::table('store_parent_features')->insertOrIgnore($parentRows);
                }
            }

            return redirect()
                ->route('admin.features.index')
                ->with('success', 'Feature updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
