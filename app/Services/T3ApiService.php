<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ProductMaster;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Log;


class T3ApiService
{
    private $clientId = 'chetanwines-XXX-6OzKJBNKoH18';
    private $clientSecret = 'bMjnUHUK-XXX-8hLHLJH82';

    // public function pullProductMasters()
    // {
    //     $response = Http::get(
    //         'http://chetanwinesapi.t3crm.pro/JSNPRODUCMTKHKLNLO.php',
    //         [
    //             'client_id' => $this->clientId,
    //             'client_secret' => $this->clientSecret,
    //         ]
    //     );

    //     $products = $response->json();

    //     foreach ($products as $item) {

    //         ProductMaster::updateOrCreate(
    //             [
    //                 'product_id' => $item['productid']
    //             ],
    //             [
    //                 'product_name' => $item['productname'] ?? null,
    //                 'product_category' => $item['productcategory'] ?? null,
    //                 'size' => $item['size'] ?? null,
    //                 'pack_size' => $item['packsize'] ?? null,
    //                 'type' => $item['type'] ?? null,
    //                 'product_created_time' => (
    //                     isset($item['product_created_time']) &&
    //                     $item['product_created_time'] != '0000-00-00 00:00:00'
    //                 )
    //                 ? $item['product_created_time']
    //                 : null,
    //                 'product_modified_time' => (
    //                     isset($item['product_modified_time']) &&
    //                     $item['product_modified_time'] != '0000-00-00 00:00:00'
    //                 )
    //                 ? $item['product_modified_time']
    //                 : null,
    //             ]
    //         );
    //     }
    // }

    // public function pullProductStocks()
    // {
    //     $response = Http::timeout(60)->get(
    //         'http://chetanwinesapi.t3crm.pro/JSNPRODUCMTKHKLNLO.php',
    //         [
    //             'client_id' => $this->clientId,
    //             'client_secret' => $this->clientSecret,
    //         ]
    //     );

    //     $stocks = $response->json();

    //     foreach ($stocks as $item) {

    //         ProductStock::updateOrCreate(
    //             [
    //                 'product_id' => $item['productid']
    //             ],
    //             [
    //                 'product_name' => $item['productname'] ?? null,
    //                 'product_category' => $item['productcategory'] ?? null,
    //                 'product_subcategory' => $item['productsubcategory'] ?? null,
    //                 'qty_per_unit' => $item['qty_per_unit'] ?? null,
    //                 'stock' => $item['inv_qty'] ?? 0,
    //                 'location' => $item['location'] ?? null,
    //                 'mrp' => $item['mrp'] ?? null,
    //             ]
    //         );
    //     }
    // }

    public function pullProductMasters()
    {
        try {

            $response = Http::timeout(60)
                ->retry(3, 2000)
                ->get(
                    'http://chetanwinesapi.t3crm.pro/JSNPRODUCMTKHKLNLO.php',
                    [
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                    ]
                );

            if (!$response->successful()) {

                Log::error('T3 Product Master API returned unsuccessful response.', [
                    'status' => $response->status(),
                ]);

                return false;
            }

            $products = $response->json();

            if (!is_array($products)) {

                Log::error('T3 Product Master API returned invalid JSON.', [
                    'response' => $response->body(),
                ]);

                return false;
            }

            foreach ($products as $item) {

                if (!isset($item['productid'])) {
                    continue;
                }

                ProductMaster::updateOrCreate(
                    [
                        'product_id' => $item['productid']
                    ],
                    [
                        'product_name' => $item['productname'] ?? null,
                        'product_category' => $item['productcategory'] ?? null,
                        'size' => $item['size'] ?? null,
                        'pack_size' => $item['packsize'] ?? null,
                        'type' => $item['type'] ?? null,
                        'product_created_time' => (
                            isset($item['product_created_time']) &&
                            $item['product_created_time'] !== '0000-00-00 00:00:00'
                        ) ? $item['product_created_time'] : null,
                        'product_modified_time' => (
                            isset($item['product_modified_time']) &&
                            $item['product_modified_time'] !== '0000-00-00 00:00:00'
                        ) ? $item['product_modified_time'] : null,
                    ]
                );
            }

            return true;

        } catch (\Throwable $e) {

            Log::error('T3 Product Master Sync Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return false;
        }
    }

    public function pullProductStocks()
    {
        try {

            $response = Http::timeout(60)
                ->retry(3, 2000)
                ->get(
                    'http://chetanwinesapi.t3crm.pro/JSNPRODUCMTKHKLNLO.php',
                    [
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                    ]
                );

            if (!$response->successful()) {

                Log::error('T3 Product Stock API returned unsuccessful response.', [
                    'status' => $response->status(),
                ]);

                return false;
            }

            $stocks = $response->json();

            if (!is_array($stocks)) {

                Log::error('T3 Product Stock API returned invalid JSON.', [
                    'response' => $response->body(),
                ]);

                return false;
            }

            foreach ($stocks as $item) {

                if (!isset($item['productid'])) {
                    continue;
                }

                ProductStock::updateOrCreate(
                    [
                        'product_id' => $item['productid']
                    ],
                    [
                        'product_name' => $item['productname'] ?? null,
                        'product_category' => $item['productcategory'] ?? null,
                        'product_subcategory' => $item['productsubcategory'] ?? null,
                        'qty_per_unit' => $item['qty_per_unit'] ?? null,
                        'stock' => $item['inv_qty'] ?? 0,
                        'location' => $item['location'] ?? null,
                        'mrp' => $item['mrp'] ?? null,
                    ]
                );
            }

            return true;

        } catch (\Throwable $e) {

            Log::error('T3 Product Stock Sync Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return false;
        }
    }

}