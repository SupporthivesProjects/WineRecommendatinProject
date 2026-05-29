<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductMaster;
use App\Models\ProductStock;
use App\Services\T3ApiService;

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
            'uploads.*.store_manager_id' => 'required|integer',
            'uploads.*.invoice_no' => 'required|string',
            'uploads.*.customer_name' => 'required|string',
            'uploads.*.customer_mobile' => 'required|string',
            'uploads.*.product_name' => 'required|string',
            'uploads.*.product_price' => 'required|numeric'
        ]);
    
        $rows = [];
    
        foreach ($data['uploads'] as $upload) {
    
            $rows[] = [
                'store_manager_name' => $upload['store_manager_name'],
                'store_manager_id' => $upload['store_manager_id'],
                'invoice_no' => $upload['invoice_no'],
                'customer_name' => $upload['customer_name'],
                'customer_mobile' => $upload['customer_mobile'],
                'product_name' => $upload['product_name'],
                'product_price' => $upload['product_price'],
                'type'=>'API',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
    
        DB::table('store_manager_uploads')->insert($rows);
    
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



}