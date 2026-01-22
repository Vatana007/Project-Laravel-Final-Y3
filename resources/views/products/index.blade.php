@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Product Inventory</h1>
            <p style="color: var(--text-muted);">Manage your catalog, pricing, and stock levels.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                style="margin-right: 8px;">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            Add Product
        </a>
    </div>

    <div class="card animate-fade">
        <div
            style="display: flex; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
            <input type="text" class="form-control" placeholder="🔍 Search products..."
                style="margin-bottom: 0; max-width: 300px;">
            <select class="form-control" style="margin-bottom: 0; max-width: 200px;">
                <option>All Categories</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Product Name</th>
                    <th>Category</th>
                    <th>Pricing</th>
                    <th>Stock Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td style="padding-left: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div
                                    style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                    📦</div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-main);">{{ $product->name }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $product->barcode }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span
                                style="background: #f1f5f9; color: var(--secondary); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600;">${{ number_format($product->sale_price, 2) }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Cost:
                                ${{ number_format($product->cost_price, 2) }}</div>
                        </td>
                        <td>
                            @if($product->qty <= 5)
                                <span
                                    style="display: inline-flex; align-items: center; gap: 6px; background: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                    <span style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%;"></span>
                                    Low: {{ $product->qty }}
                                </span>
                            @else
                                <span
                                    style="display: inline-flex; align-items: center; gap: 6px; background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                    <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></span>
                                    In Stock: {{ $product->qty }}
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn"
                                    style="padding: 6px; color: var(--secondary);">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn" style="padding: 6px; color: var(--danger);"
                                        onclick="return confirm('Delete this product permanently?')">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection