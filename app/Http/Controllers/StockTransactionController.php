<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    // 1. View History Log
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->latest()
            ->get();

        return view('stock.index', compact('transactions'));
    }

    // 2. Show "Create Adjustment" Form
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.create', compact('products'));
    }

    // 3. Save New Adjustment (With Safety Check)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        // --- SECURITY: Check if stock is sufficient ---
        if ($request->type === 'out') {
            if ($product->qty < $request->qty) {
                return back()->with('error', "Cannot remove {$request->qty} items. Only {$product->qty} in stock!");
            }
        }

        // 1. Create Log
        StockTransaction::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'qty' => $request->qty,
            'note' => $request->note,
        ]);

        // 2. Update Product Stock
        if ($request->type === 'in') {
            $product->increment('qty', $request->qty);
        } else {
            $product->decrement('qty', $request->qty);
        }

        return redirect()->route('stock.index')->with('success', 'Stock adjustment recorded successfully.');
    }

    // 4. Show "Edit Adjustment" Form
    public function edit($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $products = Product::all();
        return view('stock.edit', compact('transaction', 'products'));
    }

    // 5. Update Logic (Revert -> Check -> Apply)
    public function update(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);

        $request->validate([
            'type' => 'required|in:in,out',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $product = Product::findOrFail($transaction->product_id);

        // --- MATH: Calculate what stock WOULD be if we undo the old change ---
        $current_stock = $product->qty;
        $reverted_stock = $current_stock;

        // Undo the old transaction mathematically first
        if ($transaction->type === 'in') {
            // It was added, so taking it away would leave us with:
            $reverted_stock = $current_stock - $transaction->qty;
        } else {
            // It was removed, so putting it back would leave us with:
            $reverted_stock = $current_stock + $transaction->qty;
        }

        // --- SECURITY: Check if the NEW request is valid based on Reverted Stock ---
        if ($request->type === 'out') {
            if ($reverted_stock < $request->qty) {
                return back()->with('error', "Insufficient stock! You have {$reverted_stock} available, but tried to remove {$request->qty}.");
            }
        }

        // 1. Actually Revert Database Stock (Undo old)
        if ($transaction->type === 'in') {
            $product->decrement('qty', $transaction->qty);
        } else {
            $product->increment('qty', $transaction->qty);
        }

        // 2. Update Transaction Log
        $transaction->update([
            'type' => $request->type,
            'qty' => $request->qty,
            'note' => $request->note,
        ]);

        // 3. Apply New Stock Change
        if ($request->type === 'in') {
            $product->increment('qty', $request->qty);
        } else {
            $product->decrement('qty', $request->qty);
        }

        return redirect()->route('stock.index')->with('success', 'Adjustment updated successfully.');
    }

    // 6. Delete Logic (Revert -> Delete)
    public function destroy($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $product = Product::findOrFail($transaction->product_id);

        // Reverse the effect
        if ($transaction->type === 'in') {
            $product->decrement('qty', $transaction->qty);
        } else {
            $product->increment('qty', $transaction->qty);
        }

        $transaction->delete();

        return redirect()->route('stock.index')->with('success', 'Adjustment deleted and stock reversed.');
    }
}