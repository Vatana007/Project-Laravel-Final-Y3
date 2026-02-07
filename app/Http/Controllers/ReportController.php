<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ReportController extends Controller
{
    // 1. Show Sales Report
    public function sales(Request $request)
    {
        $query = Sale::with(['user', 'customer']);

        // Date Filtering
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Get Data (Newest First)
        $sales = $query->orderBy('created_at', 'desc')->get();

        // Calculate Dashboard Stats
        $totalRevenue = $sales->sum('final_total');
        $totalTransactions = $sales->count();
        // Check if your DB uses 'payment_method' or 'payment_type'. 
        // Based on the migration I gave you, it is 'payment_method'.
        $cashSales = $sales->where('payment_method', 'cash')->sum('final_total');

        return view('reports.sales', compact('sales', 'totalRevenue', 'totalTransactions', 'cashSales'));
    }

    // 2. Show Printable Invoice
    // --- ADD THIS FUNCTION ---
    public function invoice($id)
    {
        // 1. Fetch the sale with all relationships needed for the invoice
        $sale = Sale::with(['details.product', 'user', 'customer'])->findOrFail($id);

        // 2. Return the invoice view
        return view('reports.invoice', compact('sale'));
    }

    // 3. Delete Sale
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->details()->delete(); // Delete items first
        $sale->delete(); // Then delete sale

        return back()->with('success', 'Sale record deleted.');
    }

    public function printSales(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-d');
        $endDate = $request->end_date ?? date('Y-m-d');

        // Fetch same data as the report
        $sales = Sale::with('user', 'customer')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])->get();

        $totalRevenue = $sales->sum('final_total');
        $totalTransactions = $sales->count();

        // Return a simple print view
        return view('reports.print_sales', compact('sales', 'startDate', 'endDate', 'totalRevenue', 'totalTransactions'));
    }

    // 4. Stock Report (Keep existing)
    public function stock()
    {
        return view('reports.stock');
    }
}