<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productImageService;
    
    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }
    
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->paginate(10);
        return view('admin.dashboard.products-tab', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.add');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {

        dd($request);

        // Native PHP superglobal, useful for debugging

        Log::debug('Store method called', ['request_data' => $request->all()]);
        $validator = Validator::make($request->all(), [
            'wine_name' => 'required|string|max:255',
            // 'type' => 'nullable|string|max:255',
            // 'sp_mentions' => 'nullable|string',
            // 'grape_variety' => 'nullable|string|max:255',
            // 'varietal_blend' => 'nullable|string|max:255',
            // 'vintage_year' => 'nullable|string|max:255',
            // 'wine_sub_region' => 'nullable|string|max:255',
            // 'winery' => 'nullable|string|max:255',
            // 'designation' => 'nullable|string|max:255',
            // 'alcohol_vol' => 'nullable|string|max:255',
            // 'residual_sugar' => 'nullable|string|max:255',
            // 'nature' => 'nullable|string|max:255',
            // 'acidity' => 'nullable|string|max:255',
            // 'tannin_level' => 'nullable|string|max:255',
            // 'body' => 'nullable|string|max:255',
            // 'aging' => 'nullable|string|max:255',
            // 'barrel_type' => 'nullable|string|max:255',
            // 'time_spent_aging' => 'nullable|string|max:255',
            // 'closure_type' => 'nullable|string|max:255',
            // 'aroma' => 'nullable|string',
            // 'palate' => 'nullable|string',
            // 'finish' => 'nullable|string',
            // 'sweetness_level' => 'nullable|string|max:255',
            // 'glass_ware' => 'nullable|string|max:255',
            // 'retail_price' => 'nullable|numeric|min:0',
            // 'discounts' => 'nullable|string|max:255',
            // 'optimal_drinking' => 'nullable|string|max:255',
            // 'style' => 'nullable|string|max:255',
            // 'decanting_time' => 'nullable|string|max:255',
            // 'ageing_potential' => 'nullable|string|max:255',
            // 'cheese_pairing' => 'nullable|string|max:255',
            // 'importer_info' => 'nullable|string|max:255',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'primary_image' => 'nullable|numeric',
            // 'wine_story' => 'nullable|string',
            // 'country' => 'nullable|string|max:255',
            // 'tasting_notes' => 'nullable|string',
            // 'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('product_images') && count($request->file('product_images')) > 5) {
            Log::debug('Validation error: Too many images', ['file_count' => count($request->file('product_images'))]);
            return redirect()->back()
                ->withErrors(['product_images' => 'You can upload a maximum of 5 images.'])
                ->withInput();
        }
        

        if ($validator->fails()) {
            Log::debug('Validation failed', ['errors' => $validator->errors()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productData = $request->except(['product_images', 'primary_image']);
        Log::debug('Product data to be saved', ['product_data' => $productData]);

        // Create the product
        $product = Product::create($productData);
        Log::debug('Product created successfully', ['product_id' => $product->id]);

        // Handle image uploads
        if ($request->hasFile('product_images')) {
            Log::debug('Handling product image uploads');
            $this->productImageService->uploadProductImages(
                $product, 
                $request->file('product_images'),
                $request->input('primary_image')
            );
        }

        Log::debug('Redirecting to product list after successful creation');
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
        
        // Separate validation for basic product data
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
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20408',
            'primary_image' => 'nullable|numeric',
            'images_to_delete' => 'nullable|array',
            'images_to_delete.*' => 'nullable|numeric',
            'wine_story' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'tasting_notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            // Get all the validation errors
            $errors = $validator->errors();
            
            // Print the exact errors
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update basic product data
        $productData = $request->except(['product_images', 'primary_image', 'images_to_delete']);
        $product->update($productData);
       
        // Handle image operations if files were uploaded
        if ($request->hasFile('product_images')) {
            // Validate images with more detailed error reporting
            $imageValidator = Validator::make($request->all(), [
                'product_images.*' => 'file|max:10240', // Allow any file type up to 10MB
            ]);

            if ($imageValidator->fails()) {
                // Get detailed error information
                $errors = $imageValidator->errors()->toArray();
                
                // Log the detailed errors
                Log::error('Image validation errors:', $errors);
                
                // Get more information about the files
                foreach ($request->file('product_images') as $index => $file) {
                    Log::info("File {$index} details:", [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                        'extension' => $file->getClientOriginalExtension(),
                        'valid' => $file->isValid(),
                        'error' => $file->getError(),
                        'errorMessage' => $file->getErrorMessage()
                    ]);
                }
                
                // Print detailed error information and file details
                dd([
                    'validation_errors' => $errors,
                    'file_details' => collect($request->file('product_images'))->map(function($file, $index) {
                        return [
                            'index' => $index,
                            'name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                            'extension' => $file->getClientOriginalExtension(),
                            'valid' => $file->isValid(),
                            'error' => $file->getError(),
                            'errorMessage' => $file->getErrorMessage()
                        ];
                    })->toArray()
                ]);
                
                return redirect()->back()
                    ->withErrors($imageValidator)
                    ->withInput();
            }
            try {
                $imageService = app(ProductImageService::class);

                // Get images to delete
                $imagesToDelete = $request->input('images_to_delete', []);

                // Get primary image
                $primaryImage = $request->input('primary_image');

                // Get new images
                $newImages = $request->file('product_images');

                // Update images
                $imageService->updateProductImages($product, $newImages, $imagesToDelete, $primaryImage);
                
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Product image upload error: ' . $e->getMessage());
                
                return redirect()->back()
                    ->with('error', 'Error processing images: ' . $e->getMessage())
                    ->withInput();
            }
        } else {
            // Handle only deletion and primary image changes if no new uploads
            if ($request->has('images_to_delete') || $request->has('primary_image')) {
                try {
                    $imageService = app(ProductImageService::class);
                    $imagesToDelete = $request->input('images_to_delete', []);
                    $primaryImage = $request->input('primary_image');
                    
                    $imageService->updateProductImages($product, [], $imagesToDelete, $primaryImage);
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Error processing image changes: ' . $e->getMessage())
                        ->withInput();
                }
            }
        }

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully.');
    }
    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete product images
        $this->productImageService->deleteProductImages($product);

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
