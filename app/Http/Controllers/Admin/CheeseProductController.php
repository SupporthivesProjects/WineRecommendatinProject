<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheeseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheeseProductController extends Controller
{
    public function index()
    {
        $products = CheeseProduct::latest()->get();
        return view('admin.cheese-products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.cheese-products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/cheese-products', $imageName);
            $validated['image'] = 'cheese-products/' . $imageName;
        }

        $validated['is_active'] = $request->has('is_active');

        CheeseProduct::create($validated);

        return redirect()->route('admin.cheese-products.index')
            ->with('success', 'Cheese product created successfully.');
    }

    public function show(CheeseProduct $product)
    {
        $product->load('stores');
        return view('admin.cheese-products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = CheeseProduct::findOrFail($id);
        return view('admin.cheese-products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Find the product by ID
        $product = CheeseProduct::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'sometimes|boolean'
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::delete('public/' . $product->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/cheese-products', $imageName);
                $validated['image'] = 'cheese-products/' . $imageName;
            }
            
            // Handle is_active checkbox
            $validated['is_active'] = $request->boolean('is_active');

            // Update the product
            $product->update($validated);

            return redirect()->route('admin.cheese-products.index')
                ->with('success', 'Cheese product updated successfully');
                
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating cheese product: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Error updating product. Please try again.');
        }
    }

    public function destroy(CheeseProduct $product)
    {
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.cheese-products.index')
            ->with('success', 'Cheese product deleted successfully');
    }

    /**
     * Get cheese product details in JSON format
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProductDetails($id)
    {
        $product = CheeseProduct::with('stores')->findOrFail($id);
        
        // Format the response
        $response = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image ? asset('storage/' . $product->image) : null,
            'is_active' => $product->is_active,
            'created_at' => $product->created_at ? $product->created_at->format('M d, Y h:i A') : null,
            'updated_at' => $product->updated_at ? $product->updated_at->format('M d, Y h:i A') : null,
            'stores' => $product->stores->map(function($store) {
                return [
                    'id' => $store->id,
                    'store_name' => $store->store_name,
                    'quantity' => $store->pivot->quantity,
                    'is_active' => $store->pivot->is_active,
                    'last_updated' => $store->pivot->updated_at ? $store->pivot->updated_at->diffForHumans() : null
                ];
            })
        ];

        return response()->json($response);
    }
}
