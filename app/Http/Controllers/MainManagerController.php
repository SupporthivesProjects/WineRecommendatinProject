<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class MainManagerController extends Controller
{
    public function index()
    {
        $mainManagers = User::where('role', 'main_manager')->get();
        return view('mainManager.index', compact('mainManagers'));
    }

    //store manager 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'mobile' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:store_manager,customer,main_manager'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate user by email (since email has a UNIQUE constraint)
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()
                ->withErrors(['duplicate' => 'A user with this email already exists.'])
                ->withInput();
        }

        // Create the user
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.main_manager')
            ->with('success', 'User created successfully.');
    }

    
    public function dashboard(Request $request)
    {
        $managerId = Auth::id();

        // 1. All stores under this manager
        $storeIds = Store::where('manager_id', $managerId)->pluck('id');

        // 2. Check if a specific store is selected
        $selectedStoreId = $request->input('store_id');
        $filteredStoreIds = $selectedStoreId ? [$selectedStoreId] : $storeIds;

        // Flash messages for store change
        if ($selectedStoreId) {
            if (!$storeIds->contains($selectedStoreId)) {
                return redirect()->route('main-manager.dashboard')->with('error', 'Invalid store selected.');
            } else {
                session()->flash('success', 'Store changed successfully.');
            }
        }

        // Get date range from request or set defaults
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->subDays(7)->startOfDay();
            
        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        // Ensure start date is not after end date
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // 3. Store users
        $storeUserIds = User::whereIn('store_id', $filteredStoreIds)->pluck('id');

        // 4. Get cart_checkouts within date range
        $cartCheckouts = DB::table('cart_checkouts')
            ->whereIn('store_manager_id', $storeUserIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get(['products', 'created_at']);

        // Quantity Calculation
        $totalQuantity = 0;
        foreach ($cartCheckouts as $checkout) {
            $decodedOnce = json_decode($checkout->products, true);
            $products = is_string($decodedOnce) ? json_decode($decodedOnce, true) : $decodedOnce;
            if (is_array($products)) {
                foreach ($products as $product) {
                    if (isset($product['quantity'])) {
                        $totalQuantity += (int)$product['quantity'];
                    }
                }
            }
        }

        // Featured / All Products Count
        $featuredProductCount = DB::table('store_products')
            ->whereIn('store_id', $filteredStoreIds)
            ->where('is_featured', 1)
            ->count();

        $allProductCount = DB::table('store_products')
            ->whereIn('store_id', $filteredStoreIds)
            ->count();

        $storeCount = count($filteredStoreIds);

        // Wine Type Chart
        $productIds = DB::table('store_products')
            ->whereIn('store_id', $filteredStoreIds)
            ->pluck('product_id');

        $typeCounts = DB::table('products')
            ->whereIn('id', $productIds)
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $productTypeLabels = array_keys($typeCounts);
        $productTypeData = array_values($typeCounts);

        // Country Chart
        $countryCounts = DB::table('products')
            ->whereIn('id', $productIds)
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->pluck('count', 'country')
            ->toArray();

        $countryLabels = array_keys($countryCounts);
        $countryData = array_values($countryCounts);

        // Quantity by Date (Last 7 Days)
        $checkoutsLast7Days = DB::table('cart_checkouts')
            ->whereIn('store_manager_id', $storeUserIds)
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->get(['products', 'created_at']);

        $dailyQuantities = [];
        $dailyAmounts = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays(6 - $i)->format('Y-m-d');
            $dailyQuantities[$date] = 0;
            $dailyAmounts[$date] = 0;
        }

        foreach ($checkoutsLast7Days as $checkout) {
            $date = Carbon::parse($checkout->created_at)->format('Y-m-d');
            $decodedOnce = json_decode($checkout->products, true);
            $products = is_string($decodedOnce) ? json_decode($decodedOnce, true) : $decodedOnce;

            if (is_array($products)) {
                foreach ($products as $product) {
                    $qty = isset($product['quantity']) ? (int)$product['quantity'] : 0;
                    $price = isset($product['retail_price']) ? (float)$product['retail_price'] : 0;
                    $dailyQuantities[$date] += $qty;
                    $dailyAmounts[$date] += ($qty * $price);
                }
            }
        }

        // Dropdown Options: Store list
        $managerStores = Store::where('manager_id', $managerId)->get();

        return view('mainManager.dashboard', [
            'managerId' => $managerId,
            'storeCount' => $storeCount,
            'featuredProductCount' => $featuredProductCount,
            'allProductCount' => $allProductCount,
            'totalQuantitySold' => $totalQuantity,
            'productTypeLabels' => $productTypeLabels,
            'productTypeData' => $productTypeData,
            'countryLabels' => $countryLabels,
            'countryData' => $countryData,
            'salesLabels' => array_keys($dailyQuantities),
            'salesData' => array_values($dailyQuantities),
            'amountLabels' => array_keys($dailyAmounts),
            'amountData' => array_values($dailyAmounts),
            'managerStores' => $managerStores,
            'selectedStoreId' => $selectedStoreId,
        ]);
    }


    public function MainManagerAllStores()
    {
        $managerId = Auth::id();

        // Fetch stores for this manager with required fields only
        $stores = Store::where('manager_id', $managerId)
            ->select('id','store_name', 'contact_number', 'email', 'business_type', 'address')
            ->get();

        // Pass to view
        return view('mainManager.allStores', [
            'stores' => $stores,
        ]);
    }

    public function getStoreDetails($storeId)
    {
        $managerId = Auth::id();

        $store = Store::where('id', $storeId)
                    ->where('manager_id', $managerId)
                    ->firstOrFail();
    

        // All products for the store
        $products = DB::table('store_products')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->where('store_products.store_id', $storeId)
            ->select('products.*')
            ->get();
        
        // Featured products
        $featuredProducts = DB::table('store_products')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->where('store_products.store_id', $storeId)
            ->where('store_products.is_featured', 1)
            ->select('products.*')
            ->get();
        
        

        $userIds = User::where('store_id', $storeId)
            ->where('role', 'user')
            ->pluck('id')
            ->toArray();

        $sales = DB::table('cart_checkouts')
            ->whereIn('store_manager_id', $userIds)
            ->get(['products', 'created_at']);
        

        $salesData = [];

        foreach ($sales as $sale) {
            $date = \Carbon\Carbon::parse($sale->created_at)->format('Y-m-d');
            $decodedOnce = json_decode($sale->products, true);
            $productsInSale = is_string($decodedOnce) ? json_decode($decodedOnce, true) : $decodedOnce;

            if (is_array($productsInSale)) {
                foreach ($productsInSale as $product) {
                    $salesData[] = [
                        'date' => $date,
                        'product_name' => $product['name'] ?? 'N/A',
                        'price' => $product['retail_price'] ?? 0,
                    ];
                }
            }
        }

        $storeManagers = User::where('store_id', $storeId)
            ->where('role', 'store_manager')
            ->get(['id', 'first_name', 'email','mobile']);


        
        
        return view('mainManager.store_details', [
            'store' => $store,
            'products' => $products,
            'featuredProducts' => $featuredProducts,
            'salesData' => $salesData,
            'storeManagers' => $storeManagers,
        ]);
    }




    

}
