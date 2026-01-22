<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    public function index()
    {
        // "Powerful": Pagination and Eager Loading for performance
        $transactions = StockTransaction::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('stock.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'type' => 'required|in:in,out,broken,return',
            'qty' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            // 1. Log the transaction
            StockTransaction::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'type' => $request->type,
                'qty' => $request->qty,
                'date' => now(),
            ]);

            // 2. Update the actual Product Stock
            $product = Product::findOrFail($request->product_id);

            if ($request->type === 'in' || $request->type === 'return') {
                $product->increment('qty', $request->qty);
            } else {
                // Stock Out or Broken
                if ($product->qty < $request->qty) {
                    throw new \Exception("Not enough stock!");
                }
                $product->decrement('qty', $request->qty);
            }
        });

        return redirect()->route('stock.index')->with('success', 'Stock adjustment recorded successfully.');
    }
}