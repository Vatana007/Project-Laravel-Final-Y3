@extends('layout.app')

@section('title', 'Edit Product')

@section('content')

    <div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Edit Product</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Updating details for: <strong>{{ $product->name }}</strong></p>
        </div>

        <div class="card animate-fade"
            style="padding: 2.5rem; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Basic Information
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="modern-input" value="{{ $product->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="modern-input">
                                <option value="">Select Category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label>Barcode / SKU</label>
                        <input type="text" name="barcode" class="modern-input" value="{{ $product->barcode }}">
                    </div>
                </div>

                <div style="margin-bottom: 2.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Pricing & Inventory
                    </h3>

                    <div class="grid-3">
                        <div class="form-group">
                            <label>Buying Price ($)</label>
                            <input type="number" step="0.01" min="0" name="cost_price" class="modern-input" 
                                value="{{ $product->cost_price }}" required>
                        </div>

                        <div class="form-group">
                            <label>Sale Price ($)</label>
                            <input type="number" step="0.01" min="0" name="sale_price" class="modern-input" 
                                value="{{ $product->sale_price }}" required>
                        </div>

                        <div class="form-group">
                            <label>Current Quantity</label>
                            <input type="number" min="0" name="qty" class="modern-input" 
                                value="{{ $product->qty }}" required>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <a href="{{ route('products.index') }}" class="btn" style="flex: 1; background: white; border: 1px solid var(--border); color: var(--text-main); justify-content: center; font-weight: 600;">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; font-weight: 600; padding: 0.8rem;">Update Product</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 600px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }
        .form-group label { display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem; letter-spacing: 0.03em; }
        .modern-input { width: 100%; padding: 0.8rem 1rem; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; color: var(--text-main); transition: all 0.2s ease; }
        .modern-input:focus { background-color: white; border-color: var(--primary); outline: none; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1); }
    </style>

@endsection