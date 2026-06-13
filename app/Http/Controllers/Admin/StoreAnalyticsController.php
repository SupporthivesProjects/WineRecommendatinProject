<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckoutItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreAnalyticsController extends Controller
{
    public function topSellingWines($storeManagerId)
    {
        $topWines = CheckoutItem::select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_sold')
            )
            ->where('store_manager_id', $storeManagerId)
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return response()->json($topWines);
    }

    public static function getStoreSummary($storeManagerId, $range = 'all')
    {
        $query = CheckoutItem::where(
            'store_manager_id',
            $storeManagerId
        );
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        $totalRevenue = (clone $query)
            ->selectRaw('SUM(price * quantity) as revenue')
            ->value('revenue');
    
        $totalBottles = (clone $query)
            ->sum('quantity');
    
        $totalOrders = (clone $query)
            ->distinct('checkout_id')
            ->count('checkout_id');
    
        $avgOrderValue = $totalOrders > 0
            ? round(($totalRevenue ?? 0) / $totalOrders, 2)
            : 0;
    
        \Log::info([
            'range' => $range,
            'revenue' => $totalRevenue,
            'orders' => $totalOrders,
            'bottles' => $totalBottles,
        ]);


        return [
            'total_revenue' => round($totalRevenue ?? 0, 2),
            'total_bottles' => $totalBottles,
            'total_orders' => $totalOrders,
            'avg_order_value' => $avgOrderValue,
        ];
    }

    public static function getTopSellingWines($storeManagerId,$range = 'all',$limit = 5)
    {
        $query = CheckoutItem::where(
            'store_manager_id',
            $storeManagerId
        );
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        return $query
            ->select(
                'product_name',
                DB::raw('SUM(quantity) as total_sold')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public static function getRevenueTrend($storeManagerId,$range = 'all')
    {
        $query = CheckoutItem::where(
            'store_manager_id',
            $storeManagerId
        );
    
        self::applyDateFilter(
            $query,
            $range
        );

        $result = $query
            ->selectRaw("
                DATE(created_at) as sale_date,
                SUM(price * quantity) as revenue
            ")
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sale_date')
            ->get();

        \Log::info([
            'revenue_trend_range' => $range,
            'points' => $result->toArray()
        ]);

        return $result;
    
    }

    public static function getWineTypeDistribution($storeManagerId,$range = 'all')
    {
        $query = CheckoutItem::query()
            ->join('products', 'checkout_items.product_id', '=', 'products.id')
            ->where('checkout_items.store_manager_id', $storeManagerId);
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        return $query
            ->select(
                'products.type',
                DB::raw('SUM(checkout_items.quantity) as total_sold')
            )
            ->groupBy('products.type')
            ->orderByDesc('total_sold')
            ->get();
    }


    public static function getCountryDistribution(
        $storeManagerId,
        $range = 'all'
    )
    {
        $query = CheckoutItem::query()
            ->join(
                'products',
                'checkout_items.product_id',
                '=',
                'products.id'
            )
            ->where(
                'checkout_items.store_manager_id',
                $storeManagerId
            );
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        return $query
            ->select(
                'products.country',
                DB::raw(
                    'SUM(checkout_items.quantity) as total_sold'
                )
            )
            ->whereNotNull('products.country')
            ->where('products.country', '!=', '')
            ->groupBy('products.country')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();
    }



    public static function getSlowMovingWines(
        $storeManagerId,
        $range = 'all',
        $limit = 10
    )
    {
        $query = CheckoutItem::where(
            'store_manager_id',
            $storeManagerId
        );
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        return $query
            ->select(
                'product_name',
                DB::raw('SUM(quantity) as total_sold')
            )
            ->groupBy('product_name')
            ->orderBy('total_sold')
            ->limit($limit)
            ->get();
    }

    public static function getLowStockWines(
        $storeManagerId,
        $threshold = 5
    )
    {
        return DB::table('store_manager_uploads as s1')
            ->select(
                's1.product_name',
                's1.stock'
            )
            ->where(
                's1.store_manager_id',
                $storeManagerId
            )
            ->whereRaw('s1.id = (
                SELECT MAX(s2.id)
                FROM store_manager_uploads s2
                WHERE s2.product_name = s1.product_name
            )')
            ->where('s1.stock', '>', 0)
            ->where('s1.stock', '<=', $threshold)
            ->orderBy('s1.stock')
            ->get();
    }

    public static function getHighStockLowMovement(
        $storeManagerId,
        $range = 'all'
    )
    {
        $salesQuery = CheckoutItem::where(
            'store_manager_id',
            $storeManagerId
        );
    
        self::applyDateFilter(
            $salesQuery,
            $range
        );
    
        $sales = $salesQuery
            ->select(
                'product_name',
                DB::raw('SUM(quantity) as total_sold')
            )
            ->groupBy('product_name')
            ->get()
            ->keyBy('product_name');
    
        $latestStocks = DB::table('store_manager_uploads as s1')
            ->select(
                's1.product_name',
                's1.stock'
            )
            ->where(
                's1.store_manager_id',
                $storeManagerId
            )
            ->whereRaw('s1.id = (
                SELECT MAX(s2.id)
                FROM store_manager_uploads s2
                WHERE s2.product_name = s1.product_name
            )')
            ->get();
    
        return $latestStocks
            ->map(function ($wine) use ($sales) {
    
                $sold = $sales[$wine->product_name]->total_sold ?? 0;
    
                return (object)[
                    'product_name' => $wine->product_name,
                    'stock' => $wine->stock,
                    'sold' => $sold
                ];
            })
            ->filter(function ($wine) {
    
                return
                    $wine->stock >= 20 &&
                    $wine->sold <= 5;
    
            })
            ->sortByDesc('stock')
            ->take(10)
            ->values();
    }

    public static function getPriceBandAnalytics(
        $storeManagerId,
        $range = 'all'
    )
    {
        $query = CheckoutItem::where(
            'store_manager_id',
            $storeManagerId
        );
    
        self::applyDateFilter(
            $query,
            $range
        );
    
        $items = $query->get();
    
        return collect([
    
            [
                'band' => '0 - 5000',
                'qty' => $items
                    ->where('price', '<=', 5000)
                    ->sum('quantity')
            ],
    
            [
                'band' => '5000 - 25000',
                'qty' => $items
                    ->whereBetween(
                        'price',
                        [5001, 25000]
                    )
                    ->sum('quantity')
            ],
    
            [
                'band' => '25000 - 50000',
                'qty' => $items
                    ->whereBetween(
                        'price',
                        [25001, 50000]
                    )
                    ->sum('quantity')
            ],
    
            [
                'band' => '50000 - 100000',
                'qty' => $items
                    ->whereBetween(
                        'price',
                        [50001, 100000]
                    )
                    ->sum('quantity')
            ],
    
            [
                'band' => '100000+',
                'qty' => $items
                    ->where('price', '>', 100000)
                    ->sum('quantity')
            ]
    
        ]);
    }

    private static function applyDateFilter($query, $range)
    {
        switch ($range) {

            case 'today':
                $query->whereDate('checkout_items.created_at', today());
                break;

            case '7days':
                $query->where(
                    'checkout_items.created_at',
                    '>=',
                    now()->subDays(7)
                );
                break;

            case '30days':
                $query->where(
                    'checkout_items.created_at',
                    '>=',
                    now()->subDays(30)
                );
                break;

            case 'month':
                $query->whereMonth(
                    'checkout_items.created_at',
                    now()->month
                )->whereYear(
                    'checkout_items.created_at',
                    now()->year
                );
                break;

            case 'year':
                $query->whereYear(
                    'checkout_items.created_at',
                    now()->year
                );
                break;

            case 'custom':

                if (
                    request('from') &&
                    request('to')
                ) {

                    $query->whereBetween(
                        'checkout_items.created_at',
                        [
                            request('from') . ' 00:00:00',
                            request('to') . ' 23:59:59'
                        ]
                    );
                }

                break;
        }

        return $query;
    }

}