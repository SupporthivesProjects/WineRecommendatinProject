<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireLog;
use App\Models\StoreManagerUpload;
use App\Models\CheckoutItem;

use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CartCheckout;



class StoreDashboardController extends Controller
{
    public function index()
    {
        // Step 1: Get current user and their store ID
        $user = auth()->user(); // Assuming Auth is set up
        $storeId = $user->store_id;

        // Step 2: Get product IDs for this store from store_products
        $storeProductIds = DB::table('store_products')
            ->where('store_id', $storeId)
            ->where('status', 'active')
            ->pluck('product_id')
            ->toArray();

        $cheeseProductsCount = DB::table('store_inventory')
            ->where('store_id', $storeId)
            ->where('is_available', 1)
            ->count();



        $featuredCount = DB::table('store_products')
        ->where('store_id', $storeId)
        ->where('is_featured', 1)
        ->count();
        

        // Step 3: Get all product details for this store
        $products = Product::whereIn('id', $storeProductIds)->get();

        // Step 4: Wine type pie chart
        $productTypes = Product::whereIn('id', $storeProductIds)
            ->select('type')
            ->selectRaw('count(*) as count')
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();

        $productTypeLabels = array_keys($productTypes);
        $productTypeData = array_values($productTypes);

        if (empty($productTypeLabels)) {
            $productTypeLabels = ['Red Wine', 'White Wine', 'Rosé', 'Sparkling'];
            $productTypeData = [0, 0, 0, 0];
        }

        // Step 5: Grape variety pie chart
        $productsByGrape = Product::whereIn('id', $storeProductIds)
            ->select('grape_variety')
            ->selectRaw('count(*) as count')
            ->whereNotNull('grape_variety')
            ->groupBy('grape_variety')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $grapeLabels = [];
        $grapeData = [];

        if ($productsByGrape->count() > 0) {
            foreach ($productsByGrape as $grape) {
                $grapeLabels[] = ucfirst($grape->grape_variety ?: 'Unspecified');
                $grapeData[] = $grape->count;
            }
        } else {
            $grapeLabels = ['Cabernet Sauvignon', 'Chardonnay', 'Merlot', 'Pinot Noir', 'Sauvignon Blanc'];
            $grapeData = [0, 0, 0, 0, 0];
        }

        // Step 6: Country pie chart
        $productsByCountry = Product::whereIn('id', $storeProductIds)
            ->select('country')
            ->selectRaw('count(*) as count')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $countryLabels = [];
        $countryData = [];

        if ($productsByCountry->count() > 0) {
            foreach ($productsByCountry as $country) {
                $countryLabels[] = $country->country ?: 'Unspecified';
                $countryData[] = $country->count;
            }
        } else {
            $countryLabels = ['France', 'Italy', 'Spain', 'USA', 'Australia'];
            $countryData = [0, 0, 0, 0, 0];
        }

        // Step 7: Price range pie chart
        $priceRanges = [
            'Under $20' => [0, 20],
            '$20-$50' => [20, 50],
            '$50-$100' => [50, 100],
            '$100-$200' => [100, 200],
            'Over $200' => [200, 999999]
        ];

        $priceLabels = array_keys($priceRanges);
        $priceData = [];

        foreach ($priceRanges as $range => $limits) {
            $count = Product::whereIn('id', $storeProductIds)
                ->where('retail_price', '>=', $limits[0])
                ->where('retail_price', '<', $limits[1])
                ->count();
            $priceData[] = $count;
        }


        // QUESTIONNAIRE CHART DATA (filtered by users of current store)
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::now()->subDays($i)->format('d M');
        }

        $responseData = DB::table('question_responses')
            ->join('users', 'question_responses.user_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(question_responses.created_at) as date'),
                DB::raw('COUNT(DISTINCT question_responses.submission_id) as count')
            )
            ->where('question_responses.created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->where('users.store_id', $storeId)
            ->groupBy(DB::raw('DATE(question_responses.created_at)'))
            ->orderBy('date')
            ->get();

        $graphData = array_fill(0, count($dates), 0);
        foreach ($responseData as $row) {
            $dateLabel = Carbon::parse($row->date)->format('d M');
            $index = array_search($dateLabel, $dates);
            if ($index !== false) {
                $graphData[$index] = $row->count;
            }
        }


        return view('store-manager.storedashboard', compact(
            'productTypeLabels', 'productTypeData',
            'grapeLabels', 'grapeData',
            'countryLabels', 'countryData',
            'priceLabels', 'priceData',
            'products',
            'featuredCount',
            'graphData',
            'dates',
            'cheeseProductsCount'
        ));
    }

    public function test()
    {
        return view('test.dashboard');
    }

    // public function checkouts()
    // {
    //     // return view('store-manager.checkouts');

    //     $managerId = Auth::id();
    //     $orders = CartCheckout::where('store_manager_id', $managerId)
    //                 ->latest()
    //                 ->get();

    //     return view('store-manager.checkouts', compact('orders'));


    // }
    public function checkouts()
    {
        $managerId = Auth::id();

        $orders = CartCheckout::where('store_manager_id', $managerId)
                    ->latest()
                    ->get()
                    ->map(function ($order) {

                        $products = json_decode($order->products, true);

                        foreach ($products as &$p) {

                            // Fetch product from DB
                            $product = \App\Models\Product::find($p['id']);

                            // Attach image
                            $p['image'] = $product && $product->image1
                                ? asset('storage/' . $product->image1)
                                : asset('default.png');
                        }

                        $order->products = $products;
                        return $order;
                    });

        return view('store-manager.checkouts', compact('orders'));
    }
    public function uploads()
    {
        $user = Auth::user(); // logged-in user
        // return view('store-manager.uploads', compact('user'));
        
        $canBulkUpload = $user->store
            ->features()
            ->where('key', 'bulk_upload_invoices')
            ->wherePivot('enabled', 1)
            ->exists();

        $records = StoreManagerUpload::where('store_manager_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

        return view('store-manager.uploads', compact('user', 'records', 'canBulkUpload'));

    }
    
    //downloadSample
    public function StoreManagerdownloadSample()
    {
        $filename = "store_manager_sample.csv";

        $headers = [
            "invoice_no",
            "customer_name",
            "customer_mobile",
        
            "product_name",
            "product_id",
        
            "product_category",
            "product_sub_category",
        
            "product_price",
        
            "size",
            "packsize",
        
            "qty",
            "stock",
        
            "location",
        
            "product_created_time",
            "product_modified_time",
        
            "date"
        ];

        $callback = function() use ($headers) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);

        };

        return response()->streamDownload($callback,$filename);
    }
    // Upload CSV
    public function StoreManageruploadCSV(Request $request)
    {
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        unset($data[0]); // Remove header row

        $user = Auth::user();

        foreach ($data as $row) {

            if (empty($row[3])) {
                continue;
            }

            StoreManagerUpload::create([

                'store_manager_name' => $user->first_name . ' ' . $user->last_name,
                'store_manager_id'   => $user->id,

                'invoice_no'         => $row[0] ?? null,
                'customer_name'      => $row[1] ?? null,
                'customer_mobile'    => $row[2] ?? null,

                'product_name'       => $row[3] ?? null,
                'product_id'         => $row[4] ?? null,

                'product_category'   => $row[5] ?? null,
                'product_sub_category' => $row[6] ?? null,

                'product_price'      => $row[7] ?? null,

                'size'               => $row[8] ?? null,
                'packsize'           => $row[9] ?? null,

                'qty'                => !empty($row[10]) ? $row[10] : null,
                'stock'              => !empty($row[11]) ? $row[11] : null,

                'location'           => $row[12] ?? null,

                // Format: 15/06/2026, 04:27 PM
                'product_created_time' => !empty($row[13])
                    ? Carbon::createFromFormat('d/m/Y, h:i A', trim($row[13]))
                    : null,

                // Format: 15/06/2026, 04:27 PM
                'product_modified_time' => !empty($row[14])
                    ? Carbon::createFromFormat('d/m/Y, h:i A', trim($row[14]))
                    : null,

                // Format: 2026-06-15
                'date' => !empty($row[15])
                    ? Carbon::createFromFormat('Y-m-d', trim($row[15]))->format('Y-m-d')
                    : Carbon::today()->format('Y-m-d'),

                'type' => 'CSV',
            ]);
        }

        return redirect()
            ->route('store-manager.uploads')
            ->with('success', 'CSV Uploaded Successfully');
    }



    // Manual Entry
    public function StoreManagerManualEntry(Request $request)
    {


        $user = Auth::user();

        $upload = StoreManagerUpload::create([

            'store_manager_name' => $user->first_name . ' ' . $user->last_name,
            'store_manager_id'   => $user->id,
        
            'invoice_no'         => $request->invoice_no,
            'customer_name'      => $request->customer_name,
            'customer_mobile'    => $request->customer_mobile,
        
            'product_name'       => $request->product_name,
            'product_id'         => $request->product_id,
        
            'product_category'   => $request->product_category,
            'product_sub_category' => $request->product_sub_category,
        
            'product_price'      => $request->product_price,
        
            'size'               => $request->size,
            'packsize'           => $request->packsize,
        
            'qty'       => $request->qty,
            'stock'              => $request->stock,
        
            'location'           => $request->location,
        
            'product_created_time' => $request->product_created_time,
            'product_modified_time' => $request->product_modified_time,
        
            'type' => 'manual',
        
            'date' => Carbon::today()
        ]);

        $upload->syncToCheckoutItem();
    
        // return back()->with('success','Record Added Successfully');
        return redirect()->route('store-manager.uploads')
        ->with('success','Record Added Successfully');

    }
    public function update(Request $request, $id)
    {
        $record = StoreManagerUpload::findOrFail($id);

        // 48 hour restriction (IMPORTANT - backend safety)
        if ($record->created_at < now()->subHours(48)) {
            return response()->json([
                'success' => false,
                'message' => 'Edit window expired'
            ], 403);
        }

        $record->update([

            'invoice_no' => $request->invoice_no,
        
            'customer_name' => $request->customer_name,
            'customer_mobile' => $request->customer_mobile,
        
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
        
            'product_category' => $request->product_category,
            'product_sub_category' => $request->product_sub_category,
        
            'product_price' => $request->product_price,
        
            'size' => $request->size,
            'packsize' => $request->packsize,
        
            'qty' => $request->qty,
            'stock' => $request->stock,
        
            'location' => $request->location,
        
            'product_created_time' => $request->product_created_time,
            'product_modified_time' => $request->product_modified_time,
        ]);

        CheckoutItem::where(
            'store_manager_upload_id',
            $record->id
        )->update([
        
            'product_name' => $request->product_name,
        
            'price' => $request->product_price,
        
            'quantity' => $request->qty ?: 1,
        
            'created_at' => $request->date
                ? \Carbon\Carbon::parse($request->date)
                : now(),
        ]);

        return response()->json(['success' => true]);
    }


   

}
