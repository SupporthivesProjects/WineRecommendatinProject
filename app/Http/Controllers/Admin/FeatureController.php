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
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'key' => 'required|string|max:255|unique:features,key',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);

            $feature = Feature::create($validated);

            $rows = [];

            foreach (Store::pluck('id') as $storeId) {
                $rows[] = [
                    'store_id' => $storeId,
                    'feature_id' => $feature->id,
                    'enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('store_features')->insert($rows);

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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'key' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
    
        try {
    
            $feature = Feature::findOrFail($id);
    
            $feature->update([
                'name'        => $request->name,
                'description' => $request->description,
                'key' => $request->key,
                'status'      => $request->status,
            ]);
    
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
