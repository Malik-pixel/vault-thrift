<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $availableProducts = Product::available()->count();
        $soldProducts = Product::sold()->count();
        $inventoryValue = (int) Product::available()->sum('price');

        $monthlyOrdersCount = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendingOrdersCount = Order::where('status', Order::STATUS_PENDING)->count();
        $pendingOrdersValue = (int) Order::where('status', Order::STATUS_PENDING)->sum('price_snapshot');

        $readyOrdersCount = Order::where('status', Order::STATUS_PAID)->count();
        $readyOrdersValue = (int) Order::where('status', Order::STATUS_PAID)->sum('price_snapshot');

        $completedOrdersCount = Order::whereIn('status', [Order::STATUS_SHIPPING, Order::STATUS_DONE])->count();
        $completedRevenue = (int) Order::whereIn('status', [Order::STATUS_PAID, Order::STATUS_SHIPPING, Order::STATUS_DONE])->sum('price_snapshot');

        $recentOrders = Order::with('product')
            ->latest('id')
            ->take(6)
            ->get();

        $recentProducts = Product::with(['category', 'images'])
            ->latest('id')
            ->take(5)
            ->get();

        $categories = Category::withCount([
            'products',
            'products as available_count' => fn ($q) => $q->where('status', Product::STATUS_AVAILABLE),
        ])->orderBy('sort_order')->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'availableProducts',
            'soldProducts',
            'inventoryValue',
            'monthlyOrdersCount',
            'pendingOrdersCount',
            'pendingOrdersValue',
            'readyOrdersCount',
            'readyOrdersValue',
            'completedOrdersCount',
            'completedRevenue',
            'recentOrders',
            'recentProducts',
            'categories'
        ));
    }
}

