@extends('layout.app')

@section('content')
    <div class="header">
        <div>
            <h1 class="page-title">Point of Sale</h1>
            <p style="color: var(--text-muted);">Select products to add to cart</p>
        </div>
        <div style="text-align: right;">
            <span style="font-weight: 600; color: var(--primary);">Cashier:</span> {{ auth()->user()->name }}
        </div>
    </div>

    <div class="pos-layout animate-fade">

        <div class="pos-products">
            <div style="margin-bottom: 1.5rem; position: sticky; top: 0; z-index: 10;">
                <input type="text" class="form-control" placeholder="🔍  Search by name or barcode..."
                    style="box-shadow: var(--shadow-md); border: none;">
            </div>

            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div
                            style="height: 100px; background: #f1f5f9; border-radius: 6px; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 2rem;">
                            📦
                        </div>
                        <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.2rem;">{{ $product->name }}</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">Stock: {{ $product->qty }}</div>
                        <div class="product-price">${{ number_format($product->sale_price, 2) }}</div>

                        <form action="{{ route('pos.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="btn btn-primary" style="width: 100%; padding: 0.5rem; font-size: 0.85rem;">+
                                Add</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pos-cart">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); background: #fff;">
                <h3 style="font-size: 1.1rem;">Current Order</h3>
            </div>

            <div class="cart-items">
                @if(empty($cart))
                    <div style="text-align: center; color: var(--text-muted); padding-top: 3rem;">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">🛒</div>
                        Cart is empty
                    </div>
                @else
                    @foreach($cart as $item)
                        <div class="cart-item">
                            <div>
                                <div style="font-weight: 600;">{{ $item['name'] }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $item['qty'] }} x
                                    ${{ number_format($item['price'], 2) }}</div>
                            </div>
                            <div style="font-weight: bold;">
                                ${{ number_format($item['price'] * $item['qty'], 2) }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="cart-summary">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: var(--text-muted);">Subtotal</span>
                    <strong>${{ number_format($total ?? 0, 2) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 1.25rem;">
                    <span>Total</span>
                    <strong style="color: var(--primary);">${{ number_format($total ?? 0, 2) }}</strong>
                </div>

                <form action="{{ route('pos.checkout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem;">
                        Confirm Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection