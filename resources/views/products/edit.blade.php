@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Edit Product</h1>
            <p style="color: var(--text-muted);">Update details for: <strong>{{ $product->name }}</strong></p>
        </div>
        <a href="{{ route('products.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Back</a>
    </div>

    <div class="card animate-fade" style="max-width: 800px;">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h3
                style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                Product Information</h3>

            <div class="form-grid-2">
                <div>
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                <div>
                    <label>Barcode / SKU</label>
                    <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
                </div>
            </div>

            <div class="form-grid-2">
                <div>
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Stock Quantity</label>
                    <input type="number" name="qty" class="form-control" value="{{ $product->qty }}">
                </div>
            </div>

            <h3
                style="margin: 2rem 0 1.5rem 0; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                Pricing</h3>

            <div class="form-grid-2">
                <div>
                    <label>Cost Price ($)</label>
                    <input type="number" step="0.01" name="cost_price" class="form-control"
                        value="{{ $product->cost_price }}">
                </div>
                <div>
                    <label>Selling Price ($)</label>
                    <input type="number" step="0.01" name="sale_price" class="form-control"
                        value="{{ $product->sale_price }}" required>
                </div>
            </div>

            <div style="margin-top: 2rem; text-align: right;">
                <button class="btn btn-primary" style="padding: 0.8rem 2rem;">Update Product</button>
            </div>
        </form>
    </div>
@endsection