<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->paginate(10);
        return redirect()->route('admin.dashboard')->with('activeTab', 'products');
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wine_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sp_mentions' => 'nullable|string',
            'grape_variety' => 'nullable|string|max:255',
            'varietal_blend' => 'nullable|string|max:255',
            'vintage_year' => 'nullable|string|max:255',
            'wine_sub_region' => 'nullable|string|max:255',
            'winery' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'alcohol_vol' => 'nullable|string|max:255',
            'residual_sugar' => 'nullable|string|max:255',
            'nature' => 'nullable|string|max:255',
            'acidity' => 'nullable|string|max:255',
            'tannin_level' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'aging' => 'nullable|string|max:255',
            'barrel_type' => 'nullable|string|max:255',
            'time_spent_aging' => 'nullable|string|max:255',
            'closure_type' => 'nullable|string|max:255',
            'aroma' => 'nullable|string',
            'palate' => 'nullable|string',
            'finish' => 'nullable|string',
            'sweetness_level' => 'nullable|string|max:255',
            'glass_ware' => 'nullable|string|max:255',
            'retail_price' => 'nullable|numeric|min:0',
            'discounts' => 'nullable|string|max:255',
            'optimal_drinking' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'decanting_time' => 'nullable|string|max:255',
            'ageing_potential' => 'nullable|string|max:255',
            'cheese_pairing' => 'nullable|string|max:255',
            'importer_info' => 'nullable|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'wine_story' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'tasting_notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productData = $request->except(['image1', 'image2', 'image3', 'image4']);

        // Handle image uploads
        foreach (['image1', 'image2', 'image3', 'image4'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/products', $filename);
                $productData[$imageField] = $filename;
            }
        }

        Product::create($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'wine_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sp_mentions' => 'nullable|string',
            'grape_variety' => 'nullable|string|max:255',
            'varietal_blend' => 'nullable|string|max:255',
            'vintage_year' => 'nullable|string|max:255',
            'wine_sub_region' => 'nullable|string|max:255',
            'winery' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'alcohol_vol' => 'nullable|string|max:255',
            'residual_sugar' => 'nullable|string|max:255',
            'nature' => 'nullable|string|max:255',
            'acidity' => 'nullable|string|max:255',
            'tannin_level' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'aging' => 'nullable|string|max:255',
            'barrel_type' => 'nullable|string|max:255',
            'time_spent_aging' => 'nullable|string|max:255',
            'closure_type' => 'nullable|string|max:255',
            'aroma' => 'nullable|string',
            'palate' => 'nullable|string',
            'finish' => 'nullable|string',
            'sweetness_level' => 'nullable|string|max:255',
            'glass_ware' => 'nullable|string|max:255',
            'retail_price' => 'nullable|numeric|min:0',
            'discounts' => 'nullable|string|max:255',
            'optimal_drinking' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'decanting_time' => 'nullable|string|max:255',
            'ageing_potential' => 'nullable|string|max:255',
            'cheese_pairing' => 'nullable|string|max:255',
            'importer_info' => 'nullable|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'wine_story' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'tasting_notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productData = $request->except(['image1', 'image2', 'image3', 'image4']);

        // Handle image uploads
        foreach (['image1', 'image2', 'image3', 'image4'] as $imageField) {
            if ($request->hasFile($imageField)) {
                // Delete old image if exists
                if ($product->$imageField) {
                    Storage::delete('public/products/' . $product->$imageField);
                }
                
                $file = $request->file($imageField);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/products', $filename);
                $productData[$imageField] = $filename;
            }
        }

        $product->update($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete product images
        foreach (['image1', 'image2', 'image3', 'image4'] as $imageField) {
            if ($product->$imageField) {
                Storage::delete('public/products/' . $product->$imageField);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
