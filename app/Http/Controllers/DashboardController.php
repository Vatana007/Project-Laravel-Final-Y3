<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\StockTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Key Metrics
        $todayRevenue = Sale::whereDate('created_at', Carbon::today())->sum('final_total');
        $totalOrders = Sale::count();
        $lowStockItems = Product::where('qty', '<=', 5)->count();
        $totalCustomers = Customer::count();

        // 2. Recent Sales (Last 5)
        $recentSales = Sale::with('user')->latest()->take(5)->get();

        // 3. Recent Stock Activity (Last 5)
        $recentStock = StockTransaction::with('product')->latest()->take(5)->get();

        return view('dashboard', compact(
            'todayRevenue', 
            'totalOrders', 
            'lowStockItems', 
            'totalCustomers', 
            'recentSales',
            'recentStock'
        ));
    }
}