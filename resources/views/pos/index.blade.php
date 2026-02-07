@extends('layout.app')

@section('title', 'Point of Sale')

@section('content')

    <div class="pos-container">

        <div class="pos-products-area">

            <div class="pos-header">
                <div class="search-wrapper">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchPos" placeholder="Search products..." onkeyup="filterProducts()">
                </div>

                <div class="category-pills">
                    <button class="cat-pill active" onclick="filterCategory('all', this)">All Items</button>
                    @foreach($categories as $category)
                        <button class="cat-pill" onclick="filterCategory('{{ $category->id }}', this)">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="product-grid" id="productGrid">
                @forelse($products as $product)
                    <div class="product-card animate-fade" data-name="{{ strtolower($product->name) }} {{ $product->barcode }}"
                        data-category="{{ $product->category_id }}">

                        <div class="card-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span class="product-initial">{{ substr($product->name, 0, 1) }}</span>
                            @endif
                        </div>

                        <div class="card-details">
                            <h4 class="product-title">{{ $product->name }}</h4>
                            <div class="product-meta">
                                <span class="stock-badge {{ $product->qty > 0 ? 'in-stock' : 'out-stock' }}">
                                    {{ $product->qty > 0 ? $product->qty . ' in stock' : 'Out of Stock' }}
                                </span>
                                <span class="product-price">${{ number_format($product->sale_price, 2) }}</span>
                            </div>
                        </div>

                        <form action="{{ route('pos.store', $product->id) }}" method="POST" class="add-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn-add" {{ $product->qty < 1 ? 'disabled' : '' }}>
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="no-products">
                        <div style="margin-bottom: 15px; opacity: 0.5;">
                            <svg width="60" height="60" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <p>No products available.</p>
                        <a href="{{ route('products.create') }}" class="btn-link">Add Product</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="pos-sidebar">

            <div class="cart-header">
                <h3>Current Order</h3>
                <span class="order-id">INV-{{ date('dm') }}-{{ rand(10, 99) }}</span>
            </div>

            <div class="cart-items">
                @if(session('cart') && count(session('cart')) > 0)
                    @foreach(session('cart') as $id => $details)
                        <div class="cart-item animate-fade">
                            <div class="item-info">
                                <span class="item-name">{{ $details['name'] }}</span>
                                <span class="item-price">${{ number_format($details['price'], 2) }}</span>
                            </div>

                            <div class="item-actions">
                                <div class="qty-control">
                                    <a href="{{ route('pos.update', ['id' => $id, 'action' => 'decrease']) }}" class="qty-btn">-</a>
                                    <span class="qty-val">{{ $details['qty'] }}</span>
                                    <a href="{{ route('pos.update', ['id' => $id, 'action' => 'increase']) }}" class="qty-btn">+</a>
                                </div>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="item-total">${{ number_format($details['price'] * $details['qty'], 2) }}</span>
                                    <a href="{{ route('pos.update', ['id' => $id, 'action' => 'remove']) }}"
                                        class="remove-btn">&times;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-cart">
                        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <p>Cart is empty</p>
                    </div>
                @endif
            </div>

            <div class="cart-footer">

                @php $total = 0; @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $details)
                        @php $total += $details['price'] * $details['qty']; @endphp
                    @endforeach
                @endif

                <div class="summary-section">
                    <div class="summary-row"><span>Subtotal</span><span>${{ number_format($total, 2) }}</span></div>
                    <div class="summary-row"><span>Tax (0%)</span><span>$0.00</span></div>
                    <div class="total-row"><span>Total Payable</span><span>${{ number_format($total, 2) }}</span></div>
                </div>

                <form action="{{ route('pos.checkout') }}" method="POST" id="checkoutForm">
                    @csrf

                    <div class="payment-label">Payment Method</div>
                    <div class="payment-options">

                        <label class="payment-card active">
                            <input type="radio" name="payment_method" value="cash" checked onchange="setPayment('cash')">
                            <div class="card-content">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span>Cash</span>
                            </div>
                        </label>

                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="qr" onchange="setPayment('qr')">
                            <div class="card-content">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zm-6 0H6v4h2v-4zm6-6h2m0 0h-2v-2h2v2zm-6 0H6v-2h2v2zm6-6h2m0 0h-2V4h2v2zm-6 0H6V4h2v2zM6 6h.01M6 18h.01M18 6h.01M18 18h.01">
                                    </path>
                                </svg>
                                <span>QR Code</span>
                            </div>
                        </label>

                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="card" onchange="setPayment('card')">
                            <div class="card-content">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                <span>Card</span>
                            </div>
                        </label>
                    </div>

                    <button type="button" class="btn-checkout" onclick="handleCheckout()" {{ $total == 0 ? 'disabled' : '' }}>
                        Proceed to Payment
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="qrModal" class="modal-overlay">
        <div class="modal-content animate-fade">
            <div class="modal-header">
                <h3>Scan to Pay</h3>
                <button onclick="closeModal('qrModal')" class="close-btn">&times;</button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p style="color: var(--text-muted); margin-bottom: 1rem;">Please scan this code with your banking app.</p>

                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=Invoice-{{ date('ymd') }}-Total-{{ $total }}"
                    alt="Payment QR"
                    style="border-radius: 12px; border: 1px solid var(--border); padding: 10px; margin-bottom: 1.5rem;">

                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">
                    ${{ number_format($total, 2) }}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" style="width: 100%; padding: 12px; justify-content: center;"
                    onclick="submitForm()">
                    Confirm Payment Received
                </button>
            </div>
        </div>
    </div>

    <div id="cardModal" class="modal-overlay">
        <div class="modal-content animate-fade">
            <div class="modal-header">
                <h3>Card Payment</h3>
                <button onclick="closeModal('cardModal')" class="close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label
                        style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem; color:var(--text-muted);">Cardholder
                        Name</label>
                    <input type="text" class="form-control" placeholder="John Doe">
                </div>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label
                        style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem; color:var(--text-muted);">Card
                        Number</label>
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 10px; top: 10px; color: #94a3b8;" width="20" height="20"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        <input type="text" class="form-control" style="padding-left: 38px;"
                            placeholder="0000 0000 0000 0000">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label
                            style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem; color:var(--text-muted);">Expiry</label>
                        <input type="text" class="form-control" placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <label
                            style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem; color:var(--text-muted);">CVV</label>
                        <input type="text" class="form-control" placeholder="123">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" style="width: 100%; padding: 12px; justify-content: center;"
                    onclick="submitForm()">
                    Pay ${{ number_format($total, 2) }}
                </button>
            </div>
        </div>
    </div>

    <style>
        /* POS Container Layout */
        .pos-container {
            display: flex;
            height: calc(100vh - 80px);
            gap: 20px;
            overflow: hidden;
        }

        .pos-products-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: hidden;
        }

        .pos-sidebar {
            width: 380px;
            background: white;
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            /* Stack Header -> Items -> Footer */
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.03);
            height: 100%;
            /* Force it to fill the container */
            border-radius: 12px 12px 0 0;
            overflow: hidden;
            /* Important: Keeps children inside */
        }

        /* Header & Filters */
        .pos-header {
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 1rem;
        }

        .search-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .search-wrapper svg {
            position: absolute;
            left: 14px;
            top: 12px;
            color: var(--text-muted);
        }

        .search-wrapper input {
            width: 100%;
            padding: 12px 12px 12px 42px;
            border: 1px solid var(--border);
            border-radius: 50px;
            outline: none;
            background: white;
            transition: 0.2s;
        }

        .search-wrapper input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .category-pills {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .category-pills::-webkit-scrollbar {
            height: 0;
        }

        .cat-pill {
            border: 1px solid var(--border);
            background: white;
            padding: 8px 18px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: 0.2s;
            white-space: nowrap;
        }

        .cat-pill.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
            overflow-y: auto;
            padding-right: 5px;
            padding-bottom: 2rem;
        }

        .product-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: 0.2s;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .card-image {
            height: 110px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .product-initial {
            font-size: 2.5rem;
            font-weight: 800;
            color: #cbd5e1;
            text-transform: uppercase;
        }

        .card-details {
            padding: 12px;
            flex: 1;
        }

        .product-title {
            text-align: center;
            margin: 0 0 8px 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.3;
        }

        .product-meta {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .product-price {
            font-weight: 800;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .stock-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stock-badge.in-stock {
            background: #dcfce7;
            color: #166534;
        }

        .stock-badge.out-stock {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-add {
            width: 100%;
            border: none;
            background: var(--text-main);
            color: white;
            padding: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: 0.2s;
            font-size: 0.9rem;
        }

        .btn-add:hover {
            background: var(--primary);
        }

        /* Cart Sidebar */
        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .order-id {
            font-size: 0.8rem;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 4px;
            color: var(--text-muted);
            font-family: monospace;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            min-height: 0;
        }

        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .cart-item {
            margin-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 1rem;
        }

        .item-info {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .item-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-control {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border-radius: 6px;
            padding: 2px;
            border: 1px solid #e2e8f0;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--text-main);
            border-radius: 4px;
            transition: 0.1s;
            text-decoration: none;
        }

        .qty-btn:hover {
            background: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .qty-val {
            width: 32px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .remove-btn {
            color: #cbd5e1;
            font-size: 1.2rem;
            line-height: 1;
            margin-left: 8px;
            text-decoration: none;
        }

        .remove-btn:hover {
            color: var(--danger);
        }

        .empty-cart {
            text-align: center;
            color: var(--text-muted);
            margin-top: 4rem;
            opacity: 0.6;
        }

        /* Footer & Payment */
        .cart-footer {
            padding: 1.5rem;
            background: #fff;
            border-top: 1px solid var(--border);
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.03);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-main);
            padding-top: 10px;
            border-top: 1px dashed var(--border);
        }

        .payment-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 10px;
            letter-spacing: 0.05em;
            display: block;
        }

        .payment-options {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .payment-card {
            cursor: pointer;
            position: relative;
        }

        .payment-card input {
            display: none;
        }

        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 5px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #f8fafc;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .card-content svg {
            width: 24px;
            height: 24px;
            opacity: 0.6;
        }

        .card-content span {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .payment-card input:checked+.card-content {
            background: #eef2ff;
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            transform: translateY(-2px);
        }

        .payment-card input:checked+.card-content svg {
            opacity: 1;
        }

        .btn-checkout {
            width: 100%;
            padding: 14px;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-checkout:hover {
            background: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .btn-checkout:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* --- MODAL STYLES --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 400px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .modal-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--text-main);
            font-weight: 700;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-muted);
            cursor: pointer;
            line-height: 1;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.25rem;
            border-top: 1px solid var(--border);
            background: #f8fafc;
        }
    </style>

    <script>
        // 1. Payment Method Logic
        let currentPayment = 'cash';

        function setPayment(method) {
            currentPayment = method;
        }

        // 2. Checkout Router
        function handleCheckout() {
            if (currentPayment === 'cash') {
                // Cash: Immediate confirm & submit
                if (confirm("Confirm cash payment?")) {
                    submitForm();
                }
            } else if (currentPayment === 'qr') {
                // QR: Show Modal
                document.getElementById('qrModal').style.display = 'flex';
            } else if (currentPayment === 'card') {
                // Card: Show Input Modal
                document.getElementById('cardModal').style.display = 'flex';
            }
        }

        // 3. Helper to Close Modals
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        // 4. Submit the main form
        function submitForm() {
            document.getElementById('checkoutForm').submit();
        }

        // 5. Product Search Logic
        function filterProducts() {
            let input = document.getElementById('searchPos').value.toLowerCase();
            let cards = document.querySelectorAll('.product-card');

            cards.forEach(card => {
                let name = card.getAttribute('data-name');
                if (name.includes(input)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // 6. Category Filter Logic
        function filterCategory(catId, btn) {
            document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            let cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                if (catId === 'all' || card.getAttribute('data-category') == catId) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

@endsection