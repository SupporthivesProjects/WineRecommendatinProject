<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductMaster;
use App\Models\ProductStock;
use App\Services\T3ApiService;
use App\Models\User;
use App\Models\Store;


class UploadApiController extends Controller
{
    public function bulkUpload(Request $request)
    {

        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json([
                'status' => false,
                'message' => 'API key missing'
            ], 401);
        }
        
        $store = Store::where('api_key', $apiKey)->first();

        if (!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid API key'
            ], 401);
        }

        if (!$request->has('uploads')) {
            return response()->json([
                'status' => false,
                'message' => 'Request body missing'
            ], 400);
        }

        $uploads = $request->uploads;
        if (!is_array($uploads) || count($uploads) == 0) {
            return response()->json([
                'status'=>false,
                'message'=>'Uploads array required'
            ],400);
        }


        $data = $request->validate([
            'uploads' => 'required|array',
        
            'uploads.*.store_manager_name' => 'required|string',
            'uploads.*.store_manager_id' => 'required',
        
            'uploads.*.invoice_no' => 'nullable|string',
            'uploads.*.customer_name' => 'nullable|string',
            'uploads.*.customer_mobile' => 'nullable|string',
        
            'uploads.*.product_name' => 'required|string',
            'uploads.*.product_id' => 'nullable|string',
        
            'uploads.*.product_category' => 'nullable|string',
            'uploads.*.product_sub_category' => 'nullable|string',
        
            'uploads.*.product_price' => 'nullable|numeric',
        
            'uploads.*.size' => 'nullable|string',
            'uploads.*.packsize' => 'nullable|string',
        
            'uploads.*.qty' => 'nullable|integer',
            'uploads.*.stock' => 'nullable|integer',
        
            'uploads.*.location' => 'nullable|string',
        
            'uploads.*.product_created_time' => 'nullable',
            'uploads.*.product_modified_time' => 'nullable',
        ]);

        foreach ($data['uploads'] as $upload) {

            $manager = User::where('id', $upload['store_manager_id'])
                ->where('role', 'store_manager')
                ->where('status', 'active')
                ->where('store_id', $store->id)
                ->first();
        
            if (!$manager) {
        
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Store Manager for this store.'
                ], 403);
            }
        }
    
        $rows = [];
    
        foreach ($data['uploads'] as $upload) {
    
            $rows[] = [

                'store_manager_name' => $upload['store_manager_name'],
                'store_manager_id'   => $upload['store_manager_id'],
            
                'invoice_no'         => $upload['invoice_no'] ?? null,
                'customer_name'      => $upload['customer_name'] ?? null,
                'customer_mobile'    => $upload['customer_mobile'] ?? null,
            
                'product_name'       => $upload['product_name'],
            
                'product_id'         => $upload['product_id'] ?? null,
            
                'product_category'   => $upload['product_category'] ?? null,
                'product_sub_category' => $upload['product_sub_category'] ?? null,
            
                'product_price'      => $upload['product_price'] ?? null,
            
                'size'               => $upload['size'] ?? null,
                'packsize'           => $upload['packsize'] ?? null,
            
                'qty'       => $upload['qty'] ?? null,
                'stock'              => $upload['stock'] ?? null,
            
                'location'           => $upload['location'] ?? null,
            
                'product_created_time' =>
                    $upload['product_created_time'] ?? null,
            
                'product_modified_time' =>
                    $upload['product_modified_time'] ?? null,

                'date' => $upload['date'] ?? now()->format('Y-m-d'),
            
                'type' => 'API',
            
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
    

        $checkoutRows = [];
        foreach ($data['uploads'] as $upload) {

            $checkoutRows[] = [

                'checkout_id' => null,

                'product_id' => null,

                'user_id' => null,

                'store_manager_id' =>
                    $upload['store_manager_id'],

                'product_name' =>
                    $upload['product_name'],

                'price' =>
                    $upload['product_price'] ?? 0,

                'quantity' =>
                    !empty($upload['qty'])
                        ? $upload['qty']
                        : 1,

                'created_at' => now(),

                'updated_at' => now()
            ];
        }



        DB::table('store_manager_uploads')->insert($rows);
        DB::table('checkout_items')
        ->insert($checkoutRows);
    
        return response()->json([
            'status' => true,
            'message' => 'Bulk upload successful',
            'records_inserted' => count($rows)
        ]);
    
    }

    public function productMaster()
    {
        $products = ProductMaster::latest()->get();

        return view(
            'admin.api.productmaster',
            compact('products')
        );
    }

    public function productStock()
    {
        $products = ProductStock::latest()->get();

        return view(
            'admin.api.productstock',
            compact('products')
        );
    }


    public function pullProductMaster(T3ApiService $service)
    {
        $service->pullProductMasters();

        return back()->with(
            'success',
            'Product Master data pulled successfully.'
        );
    }

    public function pullProductStock(T3ApiService $service)
    {
        $service->pullProductStocks();

        return back()->with(
            'success',
            'Product Stock data pulled successfully.'
        );
    }

    public function downloadApiDocumentation()
    {
        $path = public_path('docs/API-Documentation.pdf');

        if (!file_exists($path)) {
            abort(404, 'Documentation not found.');
        }

        return response()->download(
            $path,
            'Wine_API_Documentation.pdf'
        );
    }


}