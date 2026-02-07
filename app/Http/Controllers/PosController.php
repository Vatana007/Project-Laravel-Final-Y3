<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Category; // <--- ADDED THIS
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        // 1. Fix "Undefined variable $categories" error
        $categories = Category::all();

        $products = Product::all();
        $customers = Customer::all();

        // Get cart, but default to empty array if broken
        $cart = session()->get('cart', []);
        if (!is_array($cart))
            $cart = [];

        return view('pos.index', compact('products', 'customers', 'cart', 'categories'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "qty" => 1,
                "price" => $product->sale_price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function updateCart($id, $action)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            switch ($action) {
                case 'increase':
                    $cart[$id]['qty']++;
                    break;

                case 'decrease':
                    if ($cart[$id]['qty'] > 1) {
                        $cart[$id]['qty']--;
                    } else {
                        unset($cart[$id]); // Remove if 0
                    }
                    break;

                case 'remove':
                    unset($cart[$id]);
                    break;
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function removeLink(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }

    // CHECKOUT LOGIC (Fixed for "qty" error and "payment_type" error)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');

        // Safety: Is cart empty?
        if (!$cart || !is_array($cart) || count($cart) == 0) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        try {
            DB::transaction(function () use ($request, $cart) {

                // 1. Calculate Total Safely (Fixes "Undefined array key qty")
                $total = 0;
                foreach ($cart as $id => $details) {
                    // Skip bad items that don't have price or qty
                    if (!isset($details['price']) || !isset($details['qty'])) {
                        continue;
                    }
                    $total += $details['price'] * $details['qty'];
                }

                $invoice_number = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

                // 2. Create Sale (Fixes "Unknown column payment_type")
                $sale = Sale::create([
                    'user_id' => auth()->id() ?? 1,
                    'customer_id' => $request->customer_id,
                    'invoice_number' => $invoice_number,
                    'total_amount' => $total,
                    'discount' => $request->discount ?? 0,
                    'tax' => $request->tax ?? 0,
                    'final_total' => $total - ($request->discount ?? 0),
                    'payment_method' => $request->payment_method ?? 'cash', // Uses correct column name
                ]);

                // 3. Create Details
                foreach ($cart as $id => $details) {
                    // Skip bad items again
                    if (!isset($details['price']) || !isset($details['qty']))
                        continue;

                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $id,
                        'qty' => $details['qty'],
                        'price' => $details['price'],
                        'subtotal' => $details['price'] * $details['qty']
                    ]);

                    // Deduct Stock
                    $product = Product::find($id);
                    if ($product) {
                        $product->decrement('qty', $details['qty']);
                    }
                }
            });

            // Clear cart only on success
            session()->forget('cart');
            return redirect()->route('pos.index')->with('success', 'Sale completed successfully!');

        } catch (\Exception $e) {
            // Shows the specific error on screen if it fails again
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}