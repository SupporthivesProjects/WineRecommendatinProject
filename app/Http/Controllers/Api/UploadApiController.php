<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}