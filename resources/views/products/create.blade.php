@extends('layout.app')

@section('title', 'New Product')

@section('content')

    <div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Add New Product</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Enter product details, pricing, and initial stock.</p>
        </div>

        <div class="card animate-fade"
            style="padding: 2.5rem; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 2rem;">
                    <h3
                        style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Basic Information
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Product Name</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <input type="text" name="name" class="modern-input" placeholder="e.g. Wireless Mouse"
                                    required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <select name="category_id" class="modern-input">
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label>Supplier</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <select name="supplier_id" class="modern-input">
                                <option value="">Select Supplier...</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label>Barcode / SKU (Optional)</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 4h18M3 20h18M5 8h2m4 0h2m4 0h2M5 16h2m4 0h2m4 0h2M5 12h14"></path>
                            </svg>
                            <input type="text" name="barcode" class="modern-input" placeholder="Scan or type code...">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label>Product Image</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <input type="file" name="image" class="modern-input" accept="image/*">
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 2.5rem;">
                    <h3
                        style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Pricing & Inventory
                    </h3>

                    <div class="grid-3">
                        <div class="form-group">
                            <label>Buying Price ($)</label>
                            <input type="number" step="0.01" min="0" name="cost_price" class="modern-input"
                                placeholder="0.00" required>
                        </div>

                        <div class="form-group">
                            <label>Sale Price ($)</label>
                            <input type="number" step="0.01" min="0" name="sale_price" class="modern-input"
                                placeholder="0.00" required>
                        </div>

                        <div class="form-group">
                            <label>Initial Quantity</label>
                            <input type="number" min="0" name="qty" class="modern-input" placeholder="0" required>
                        </div>
                    </div>
                </div>

                <div
                    style="display: flex; gap: 1rem; margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <a href="{{ route('products.index') }}" class="btn"
                        style="flex: 1; background: white; border: 1px solid var(--border); color: var(--text-main); justify-content: center; font-weight: 600;">Cancel</a>
                    <button type="submit" class="btn btn-primary"
                        style="flex: 2; justify-content: center; font-weight: 600; padding: 0.8rem;">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 600px) {

            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            letter-spacing: 0.03em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 12px;
            color: #94a3b8;
        }

        .modern-input {
            width: 100%;
            padding: 0.8rem 1rem;
            padding-left: 2.8rem;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .modern-input:focus {
            background-color: white;
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }
    </style>

@endsection