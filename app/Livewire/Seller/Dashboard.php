<?php

namespace App\Livewire\Seller;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.seller')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $store = $user->store;

        if (!$store) {
            return view('livewire.seller.dashboard', ['stats' => [], 'recentOrders' => collect(), 'store' => null]);
        }

        $storeId = (string) $store->_id;

        // 1. Basic Stats
        $stats = [
            'total_products' => Product::where('store_id', $storeId)->count(),
            'active_products' => Product::where('store_id', $storeId)->active()->count(),
            'low_stock' => Product::where('store_id', $storeId)->where('stock', '<=', 10)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('store_id', $storeId)->where('stock', 0)->count(),
            'pending_orders' => Order::forSeller($storeId)->byStatus(Order::STATUS_PENDING)->count(),
            'processing_orders' => Order::forSeller($storeId)->byStatus(Order::STATUS_PROCESSING)->count(),
            'total_orders_today' => Order::forSeller($storeId)->whereDate('created_at', today())->count(),
            'revenue_today' => Order::forSeller($storeId)
                ->whereDate('created_at', today())
                ->whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_PROCESSING, Order::STATUS_READY, Order::STATUS_SHIPPED])
                ->sum('total_amount'),
        ];

        // 2. Retention Analytics (Timeseries - Last 30 Days)
        $orders = Order::forSeller($storeId)
            ->where('created_at', '>=', now()->subDays(30))
            ->get(['user_id', 'created_at']);

        $dailyRetention = [];
        $usersBefore = Order::where('store_id', $storeId)
            ->where('created_at', '<', now()->subDays(30))
            ->pluck('user_id')
            ->map(fn($id) => (string)$id)
            ->unique()
            ->toArray();
        
        $seenUsers = collect($usersBefore)->flip()->toArray();

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayOrders = $orders->filter(fn($o) => $o->created_at->format('Y-m-d') === $date);
            
            $totalCount = $dayOrders->count();
            $repeatCount = 0;

            foreach ($dayOrders as $order) {
                $uid = (string) $order->user_id;
                if (isset($seenUsers[$uid])) {
                    $repeatCount++;
                }
                $seenUsers[$uid] = true;
            }

            $dailyRetention[] = [
                'x' => $date,
                'y' => $totalCount > 0 ? round(($repeatCount / $totalCount) * 100, 1) : 0,
                'total' => $totalCount
            ];
        }

        // 3. Category Sales (Pie & Treemap)
        // We aggregate from orders completed/processing in the last 90 days
        $allOrders = Order::forSeller($storeId)
            ->whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_PROCESSING, Order::STATUS_READY])
            ->where('created_at', '>=', now()->subDays(90))
            ->get(['items']);

        $categoryStats = [];
        $productIds = [];
        foreach ($allOrders as $order) {
            foreach ($order->items as $item) {
                if (!isset($item['snapshot_category'])) {
                    $productIds[] = $item['product_id'];
                }
            }
        }

        $productCategoryIds = Product::whereIn('_id', array_unique($productIds))->pluck('category_id', '_id')->toArray();
        $categoryNames = Category::pluck('name', '_id')->mapWithKeys(fn($name, $id) => [(string)$id => $name])->toArray();

        foreach ($allOrders as $order) {
            foreach ($order->items as $item) {
                $pid = (string) $item['product_id'];
                $catId = $productCategoryIds[$pid] ?? null;
                $cat = $item['snapshot_category'] ?? ($categoryNames[(string)$catId] ?? 'Lainnya');
                $categoryStats[$cat] = ($categoryStats[$cat] ?? 0) + ($item['qty'] ?? 0);
            }
        }

        arsort($categoryStats);
        $topCategories = array_slice($categoryStats, 0, 8, true);

        $recentOrders = Order::forSeller($storeId)->recent()->limit(5)->get();

        return view('livewire.seller.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'store' => $store,
            'dailyRetention' => $dailyRetention,
            'categoryStats' => $categoryStats,
            'topCategories' => $topCategories,
        ]);
    }
}
