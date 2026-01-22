<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // Get cart from session, or empty array if null
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return view('pos.index', compact('products', 'cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // If product is already in cart, increment quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty']++;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                "name" => $product->name,
                "qty" => 1,
                "price" => $product->sale_price,
                "product_id" => $product->id
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function checkout()
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        DB::transaction(function () use ($cart) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            // Create Sale Record
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'invoice_number' => 'INV-' . time(),
                'total_amount' => $total,
                'final_total' => $total,
                'payment_type' => 'Cash', // Default for now
            ]);

            // Create Sale Details & Update Stock
            foreach ($cart as $id => $details) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $id,
                    'qty' => $details['qty'],
                    'price' => $details['price'],
                    'subtotal' => $details['price'] * $details['qty']
                ]);

                // Decrease Stock
                Product::where('id', $id)->decrement('qty', $details['qty']);
            }
        });

        session()->forget('cart');
        return redirect()->back()->with('success', 'Sale completed successfully!');
    }
}