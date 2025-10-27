<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Customer;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Sales::count();
        $totalCustomers = Customer::count();
        $totalRevenue = Sales::where('status', 'completed')->sum('total_amount');
        $pendingSales = Sales::where('status', 'pending')->count();
        $latestSale = Sales::with('customer')->latest()->first();
        $recentSales = Sales::with('customer')->latest()->take(5)->get();

        // Product metrics for dashboard cards
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $lowStockProducts = Product::whereRaw('stock_quantity <= minimum_stock AND stock_quantity > 0')->count();
        $outOfStockProducts = Product::where('stock_quantity', '<=', 0)->count();

        return view('dashboard', compact(
            'totalSales', 
            'totalCustomers', 
            'totalRevenue', 
            'pendingSales', 
            'latestSale', 
            'recentSales',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }
}
