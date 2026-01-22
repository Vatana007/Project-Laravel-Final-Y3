<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the Sales Report with Date Filtering
     */
    public function sales(Request $request)
    {
        // Start a query for Sales, including the User (cashier) info
        $query = Sale::with('user');

        // Filter by Date Range if provided in the URL
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Get results ordered by newest first
        $sales = $query->orderBy('created_at', 'desc')->get();

        // Calculate total revenue from the filtered results
        $totalRevenue = $sales->sum('final_total');

        return view('reports.sales', compact('sales', 'totalRevenue'));
    }

    /**
     * Display the Stock Inventory Report
     */
    public function stock()
    {
        // The view handles the logic of displaying products and calculating totals
        // We could pass data here, but the view uses direct Model calls for simplicity 
        // as per the previous design. You can also pass $products here if you prefer.
        return view('reports.stock');
    }

    /**
     * Delete a Sale Record (and its details)
     */
    public function destroy($id)
    {
        // Find the sale or show 404
        $sale = Sale::findOrFail($id);

        // 1. Delete the specific items (SaleDetails) linked to this sale
        $sale->details()->delete();

        // 2. Delete the main Sale record
        $sale->delete();

        return back()->with('success', 'Sale record deleted successfully.');
    }
}