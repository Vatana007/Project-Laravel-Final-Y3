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
        // 1. Revenue: Changed to sum() ALL time so you can see your data (removed whereDate)
        $todayRevenue = Sale::sum('final_total');

        // 2. Orders: Count all sales
        $totalOrders = Sale::count();

        // 3. Low Stock: Count items with less than 5 qty
        $lowStockItems = Product::where('qty', '<=', 5)->count();

        // 4. Members: Count customers (Renamed variable to match your Label)
        $totalMembers = Customer::count();

        // 5. Recent Data
        $recentSales = Sale::with('user')->latest()->take(5)->get();
        $recentStock = StockTransaction::with('product')->latest()->take(5)->get();

        // Pass the correct variables to the view
        return view('dashboard', compact(
            'todayRevenue',
            'totalOrders',
            'lowStockItems',
            'totalMembers', // <--- Now matches "$totalMembers"
            'recentSales',
            'recentStock'
        ));
    }
}