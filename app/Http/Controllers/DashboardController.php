<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate totals for the dashboard cards
        $totalSales = Sale::sum('final_total');
        $todaySales = Sale::whereDate('created_at', today())->sum('final_total');
        $lowStockProducts = Product::where('qty', '<', 5)->count();
        $totalEmployees = Employee::count();

        // Simple data for a chart (last 7 days sales)
        $salesData = Sale::selectRaw('DATE(created_at) as date, SUM(final_total) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('dashboard', compact('totalSales', 'todaySales', 'lowStockProducts', 'totalEmployees', 'salesData'));
    }
}