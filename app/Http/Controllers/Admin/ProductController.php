<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        $products = Product::orderBy('id', 'asc')->get();
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
    // public function store(Request $request)
    // {

    //     // Native PHP superglobal, useful for debugging

    //     Log::debug('Store method called', ['request_data' => $request->all()]);
    //     $validator = Validator::make($request->all(), [
    //         'wine_name' => 'required|string|max:255',
    //         'type' => 'nullable|string|max:255',
    //         'sp_mentions' => 'nullable|string',
    //         'method' => 'nullable|string',
    //         'grape_variety' => 'nullable|string|max:255',
    //         'varietal_blend' => 'nullable|string|max:255',
    //         'vintage_year' => 'nullable|string|max:255',
    //         'wine_sub_region' => 'nullable|string|max:255',
    //         'winery' => 'nullable|string|max:255',
    //         'designation' => 'nullable|string|max:255',
    //         'alcohol_vol' => 'nullable|string|max:255',
    //         'residual_sugar' => 'nullable|string|max:255',
    //         'nature' => 'nullable|string|max:255',
    //         'acidity' => 'nullable|string|max:255',
    //         'tannin_level' => 'nullable|string|max:255',
    //         'body' => 'nullable|string|max:255',
    //         'aging' => 'nullable|string|max:255',
    //         'barrel_type' => 'nullable|string|max:255',
    //         'time_spent_aging' => 'nullable|string|max:255',
    //         'closure_type' => 'nullable|string|max:255',
    //         'aroma' => 'nullable|string',
    //         'palate' => 'nullable|string',
    //         'finish' => 'nullable|string',
    //         'sweetness_level' => 'nullable|string|max:255',
    //         'glass_ware' => 'nullable|string|max:255',
    //         'retail_price' => 'nullable|numeric|min:0',
    //         'discounts' => 'nullable|string|max:255',
    //         'optimal_drinking' => 'nullable|string|max:255',
    //         'style' => 'nullable|string|max:255',
    //         'decanting_time' => 'nullable|string|max:255',
    //         'ageing_potential' => 'nullable|string|max:255',
    //         'cheese_pairing' => 'nullable|array',
    //         'importer_info' => 'nullable|string|max:255',
    //         'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'primary_image' => 'nullable|numeric',
    //         'wine_story' => 'nullable|string',
    //         'country' => 'nullable|string|max:255',
    //         'tasting_notes' => 'nullable|string',
    //         'status' => 'required|in:active,inactive',
    //     ]);

    //     if ($request->hasFile('product_images') && count($request->file('product_images')) > 5) {
    //         Log::debug('Validation error: Too many images', ['file_count' => count($request->file('product_images'))]);
    //         return redirect()->back()
    //             ->withErrors(['product_images' => 'You can upload a maximum of 5 images.'])
    //             ->withInput();
    //     }
        

    //     if ($validator->fails()) {
    //         Log::debug('Validation failed', ['errors' => $validator->errors()]);
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     //$productData = $request->except(['product_images', 'primary_image']);
        
    //     // Convert cheese_pairing array to comma-separated string if it exists
    //     if ($request->has('cheese_pairing') && is_array($request->cheese_pairing)) {
    //         $productData['cheese_pairing'] = implode(',', array_map('trim', $request->cheese_pairing));
    //     } else {
    //         $productData['cheese_pairing'] = null;
    //     }
        
    //     Log::debug('Product data to be saved', ['product_data' => $productData]);

    //     // Create the product
    //     $product = Product::create($productData);
    //     Log::debug('Product created successfully', ['product_id' => $product->id]);

    //     // Handle image uploads
    //     if ($request->hasFile('product_images')) {
    //         Log::debug('Handling product image uploads');
    //         $this->productImageService->uploadProductImages(
    //             $product, 
    //             $request->file('product_images'),
    //             $request->input('primary_image')
    //         );
    //     }

    //     Log::debug('Redirecting to product list after successful creation');
    //     return redirect()->route('admin.products.index')
    //         ->with('success', 'Product created successfully.');
    // }


    public function store(Request $request)
    {
        Log::debug('Store method called', ['request_data' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'wine_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sp_mentions' => 'nullable|string',
            'method' => 'nullable|string',
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
            'cheese_pairing' => 'nullable|array',
            'importer_info' => 'nullable|string|max:255',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048', // Single image
            'wine_story' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'tasting_notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'categories' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            Log::debug('Validation failed', ['errors' => $validator->errors()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        // Start with all request data except image
        $productData = $request->except(['product_image']);

        


        // Convert cheese_pairing array to string
        if ($request->has('cheese_pairing') && is_array($request->cheese_pairing)) {
            $productData['cheese_pairing'] = implode(',', array_map('trim', $request->cheese_pairing));
        } else {
            $productData['cheese_pairing'] = null;
        }

        // Handle single image upload
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $productData['image1'] = $path; // store path in DB
        }

        Log::debug('Product data to be saved', ['product_data' => $productData]);

        \DB::listen(function ($query) {
            Log::debug('Executed query', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time
            ]);
        });

        // Create product
        $product = Product::create($productData);
        Log::debug('Product created successfully', ['product_id' => $product->id]);

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
    // public function update(Request $request, Product $product)
    // {
        
    //     // Separate validation for basic product data
    //     $validator = Validator::make($request->all(), [
    //         'wine_name' => 'required|string|max:255',
    //         'type' => 'nullable|string|max:255',
    //         'sp_mentions' => 'nullable|string',
    //         'grape_variety' => 'nullable|string|max:255',
    //         'varietal_blend' => 'nullable|string|max:255',
    //         'vintage_year' => 'nullable|string|max:255',
    //         'wine_sub_region' => 'nullable|string|max:255',
    //         'winery' => 'nullable|string|max:255',
    //         'designation' => 'nullable|string|max:255',
    //         'alcohol_vol' => 'nullable|string|max:255',
    //         'residual_sugar' => 'nullable|string|max:255',
    //         'nature' => 'nullable|string|max:255',
    //         'acidity' => 'nullable|string|max:255',
    //         'tannin_level' => 'nullable|string|max:255',
    //         'body' => 'nullable|string|max:255',
    //         'aging' => 'nullable|string|max:255',
    //         'barrel_type' => 'nullable|string|max:255',
    //         'time_spent_aging' => 'nullable|string|max:255',
    //         'closure_type' => 'nullable|string|max:255',
    //         'aroma' => 'nullable|string',
    //         'palate' => 'nullable|string',
    //         'finish' => 'nullable|string',
    //         'sweetness_level' => 'nullable|string|max:255',
    //         'glass_ware' => 'nullable|string|max:255',
    //         'retail_price' => 'nullable|numeric|min:0',
    //         'discounts' => 'nullable|string|max:255',
    //         'optimal_drinking' => 'nullable|string|max:255',
    //         'style' => 'nullable|string|max:255',
    //         'decanting_time' => 'nullable|string|max:255',
    //         'ageing_potential' => 'nullable|string|max:255',
    //         'cheese_pairing' => 'nullable|array',
    //         'importer_info' => 'nullable|string|max:255',
    //         'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20408',
    //         'primary_image' => 'nullable|numeric',
    //         'images_to_delete' => 'nullable|array',
    //         'images_to_delete.*' => 'nullable|numeric',
    //         'wine_story' => 'nullable|string',
    //         'country' => 'nullable|string|max:255',
    //         'tasting_notes' => 'nullable|string',
    //         'status' => 'required|in:active,inactive',
    //     ]);

    //     if ($validator->fails()) {
    //         // Get all the validation errors
    //         $errors = $validator->errors();
            
    //         // Print the exact errors
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }
        
    //     // Update basic product data
    //     $productData = $request->except('product_image_replace');
        
    //     // Convert cheese_pairing array to comma-separated string if it exists
    //     if ($request->has('cheese_pairing') && is_array($request->cheese_pairing)) {
    //         $productData['cheese_pairing'] = implode(',', array_map('trim', $request->cheese_pairing));
    //     } else {
    //         $productData['cheese_pairing'] = null;
    //     }
        
    //     $product->update($productData);
       
    //     // Handle image operations if files were uploaded
    //     if ($request->hasFile('product_images')) {
    //         // Validate images with more detailed error reporting
    //         $imageValidator = Validator::make($request->all(), [
    //             'product_images.*' => 'file|max:10240', // Allow any file type up to 10MB
    //         ]);

    //         if ($imageValidator->fails()) {
    //             // Get detailed error information
    //             $errors = $imageValidator->errors()->toArray();
                
    //             // Log the detailed errors
    //             Log::error('Image validation errors:', $errors);
                
    //             // Get more information about the files
    //             foreach ($request->file('product_images') as $index => $file) {
    //                 Log::info("File {$index} details:", [
    //                     'name' => $file->getClientOriginalName(),
    //                     'size' => $file->getSize(),
    //                     'mime' => $file->getMimeType(),
    //                     'extension' => $file->getClientOriginalExtension(),
    //                     'valid' => $file->isValid(),
    //                     'error' => $file->getError(),
    //                     'errorMessage' => $file->getErrorMessage()
    //                 ]);
    //             }
                
    //             // Print detailed error information and file details
    //             dd([
    //                 'validation_errors' => $errors,
    //                 'file_details' => collect($request->file('product_images'))->map(function($file, $index) {
    //                     return [
    //                         'index' => $index,
    //                         'name' => $file->getClientOriginalName(),
    //                         'size' => $file->getSize(),
    //                         'mime' => $file->getMimeType(),
    //                         'extension' => $file->getClientOriginalExtension(),
    //                         'valid' => $file->isValid(),
    //                         'error' => $file->getError(),
    //                         'errorMessage' => $file->getErrorMessage()
    //                     ];
    //                 })->toArray()
    //             ]);
                
    //             return redirect()->back()
    //                 ->withErrors($imageValidator)
    //                 ->withInput();
    //         }
    //         try {
    //             $imageService = app(ProductImageService::class);

    //             // Get images to delete
    //             $imagesToDelete = $request->input('images_to_delete', []);

    //             // Get primary image
    //             $primaryImage = $request->input('primary_image');

    //             // Get new images
    //             $newImages = $request->file('product_images');

    //             // Update images
    //             $imageService->updateProductImages($product, $newImages, $imagesToDelete, $primaryImage);
                
    //         } catch (\Exception $e) {
    //             // Log the error for debugging
    //             Log::error('Product image upload error: ' . $e->getMessage());
                
    //             return redirect()->back()
    //                 ->with('error', 'Error processing images: ' . $e->getMessage())
    //                 ->withInput();
    //         }
    //     } else {
    //         // Handle only deletion and primary image changes if no new uploads
    //         if ($request->has('images_to_delete') || $request->has('primary_image')) {
    //             try {
    //                 $imageService = app(ProductImageService::class);
    //                 $imagesToDelete = $request->input('images_to_delete', []);
    //                 $primaryImage = $request->input('primary_image');
                    
    //                 $imageService->updateProductImages($product, [], $imagesToDelete, $primaryImage);
    //             } catch (\Exception $e) {
    //                 return redirect()->back()
    //                     ->with('error', 'Error processing image changes: ' . $e->getMessage())
    //                     ->withInput();
    //             }
    //         }
    //     }

    //     return redirect()->route('admin.products.show', $product)
    //         ->with('success', 'Product updated successfully.');
    // }

    public function update(Request $request, Product $product)
{
    // Validate
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
        'cheese_pairing' => 'nullable|array',
        'importer_info' => 'nullable|string|max:255',
        'product_image_replace' => 'nullable|image|mimes:jpeg,png,webp,jpg,gif|max:2048',
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

    // Prepare product data without the image
    $productData = $request->except(['product_image_replace']);

    // Convert cheese_pairing array to string if exists
    if ($request->has('cheese_pairing') && is_array($request->cheese_pairing)) {
        $productData['cheese_pairing'] = implode(',', array_map('trim', $request->cheese_pairing));
    } else {
        $productData['cheese_pairing'] = null;
    }

    // Handle image replacement
    if ($request->hasFile('product_image_replace')) {
        // Delete old image if exists
        if ($product->image1 && \Storage::disk('public')->exists($product->image1)) {
            \Storage::disk('public')->delete($product->image1);
        }
        // Store new image
        $path = $request->file('product_image_replace')->store('products', 'public');
        $productData['image1'] = $path;
    }

    // Update product
    $product->update($productData);

    return redirect()->route('admin.products.show', $product)
        ->with('success', 'Product updated successfully.');
}




    
    /**
     * Toggle the featured status of a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFeatured(Request $request, Product $product)
    {
        try {
            $request->validate([
                'is_featured' => 'required|boolean',
            ]);

            $product->update([
                'admin_featured_product' => $request->is_featured,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully.',
                'is_featured' => $product->admin_featured_product,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating featured status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status.',
                'error' => $e->getMessage(),
            ], 500);
        }
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

    public function bulkUploadForm()
    {
        return view('admin.products.bulk-upload');
    }
    
    public function bulkUploadStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);
    
        // process file
    }

    public function downloadCSV()
    {
        $products = DB::table('products')->get();

        $filename = "products.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            if ($products->count() > 0) {
                fputcsv($file, array_keys((array)$products[0]));
            }

            foreach ($products as $product) {
                fputcsv($file, (array)$product);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function uploadCSV(Request $request)
    {
        try {

            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), "r");

            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);
                DB::table('products')->insert($data);
            }

            fclose($handle);

            return back()->with('success','Products imported successfully');

        } catch (\Exception $e) {

            return back()->with('error','Import failed: '.$e->getMessage());

        }
    }

    public function invoiceUploads(Request $request)
    {
        $invoices = DB::table('store_manager_uploads')
            ->join('users', 'store_manager_uploads.store_manager_id', '=', 'users.id')
            ->join('stores', 'users.store_id', '=', 'stores.id')
            ->select(
                'stores.store_name',
                'stores.id as store_id',
                DB::raw('DATE(store_manager_uploads.created_at) as invoice_date'),
                DB::raw('COUNT(store_manager_uploads.id) as total_invoices'),
                DB::raw('SUM(store_manager_uploads.product_price) as total_amount')
            )
            ->groupBy(
                'stores.store_name',
                'stores.id',
                DB::raw('DATE(store_manager_uploads.created_at)')
            )
            ->orderBy('invoice_date','desc')
            ->get();

        return view('admin.products.invoiceuploads', compact('invoices'));
    }


    // public function invoiceBundleDetails($store_id, $date)
    // {
    //     $details = DB::table('store_manager_uploads')
    //         ->join('users', 'store_manager_uploads.store_manager_id', '=', 'users.id')
    //         ->where('users.store_id', $store_id)
    //         ->whereDate('store_manager_uploads.created_at', $date)
    //         ->select(
    //             'store_manager_uploads.invoice_no',
    //             'store_manager_uploads.customer_name',
    //             'store_manager_uploads.customer_mobile',
    //             'store_manager_uploads.product_name',
    //             'store_manager_uploads.product_price',
    //             'store_manager_uploads.store_manager_name'
    //         )
    //         ->get();

    //     return response()->json($details);
    // }
    public function invoiceBundleDetails($store_id, $date)
    {
        $invoices = DB::table('store_manager_uploads')
            ->join('users', 'store_manager_uploads.store_manager_id', '=', 'users.id')
            ->where('users.store_id', $store_id)
            ->whereDate('store_manager_uploads.created_at', $date)
            ->select(
                'store_manager_uploads.id',
                'store_manager_uploads.invoice_no',
                'store_manager_uploads.customer_name',
                'store_manager_uploads.customer_mobile',
                'store_manager_uploads.product_name',
                'store_manager_uploads.product_price'
            )
            ->get();

        $products = DB::table('products')
            ->select('wine_name')
            ->get()
            ->pluck('wine_name')
            ->toArray();

        $result = [];

        foreach ($invoices as $invoice) {

            $uploadedName = strtolower(str_replace(' ', '', $invoice->product_name));

            $exactMatch = null;

            foreach ($products as $product) {

                $dbName = strtolower(str_replace(' ', '', $product));

                if ($uploadedName === $dbName) {
                    $exactMatch = $product;
                    break;
                }
            }

            $closestMatch = null;

            if (!$exactMatch) {

                $shortest = -1;

                foreach ($products as $product) {

                    $lev = levenshtein(
                        strtolower($invoice->product_name),
                        strtolower($product)
                    );

                    if ($lev == 0) {
                        $closestMatch = $product;
                        break;
                    }

                    if ($lev <= $shortest || $shortest < 0) {
                        $closestMatch = $product;
                        $shortest = $lev;
                    }
                }
            }

            $result[] = [
                'id' => $invoice->id,
                'invoice_no' => $invoice->invoice_no,
                'customer_name' => $invoice->customer_name,
                'customer_mobile' => $invoice->customer_mobile,
                'product_name' => $invoice->product_name,
                'product_price' => $invoice->product_price,
                'exact_match' => $exactMatch,
                'closest_match' => $closestMatch
            ];
        }

        return response()->json($result);
    }

    

    public function updateInvoiceProduct(Request $request)
    {
        DB::table('store_manager_uploads')
            ->where('id', $request->invoice_id)
            ->update([
                'product_name' => $request->product_name
            ]);

        return response()->json([
            'success' => true
        ]);
    }

}
