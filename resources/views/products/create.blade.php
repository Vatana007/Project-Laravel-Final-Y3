@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Create Product</h1>
            <p style="color: var(--text-muted);">Add a new item to your master inventory.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border); color: var(--text-main);">
            Cancel
        </a>
    </div>

    <div class="card animate-fade" style="max-width: 900px; margin: 0 auto;">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 2rem;">
                <h3
                    style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                    <span
                        style="background: #e0e7ff; color: var(--primary); padding: 4px 8px; border-radius: 6px; font-size: 0.8rem;">Step
                        1</span>
                    Basic Identification
                </h3>
                <div style="border-bottom: 1px solid var(--border); margin-bottom: 1.5rem;"></div>

                <div class="form-grid-2">
                    <div>
                        <label>Product Name <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Premium Wireless Headset"
                            required>
                    </div>
                    <div>
                        <label>Barcode / SKU <span style="color: var(--danger);">*</span></label>
                        <div style="position: relative;">
                            <input type="text" name="barcode" class="form-control" placeholder="Scan or type..."
                                style="padding-right: 40px;" required>
                            <svg style="position: absolute; right: 12px; top: 12px; color: var(--text-muted);" width="18"
                                height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 4h18M3 8h18M3 12h18M3 16h18M3 20h18"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div>
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Supplier (Optional)</label>
                        <select name="supplier_id" class="form-control">
                            <option value="">-- Select Supplier --</option>
                            @foreach(\App\Models\Supplier::all() as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3
                    style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                    <span
                        style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem;">Step
                        2</span>
                    Pricing & Inventory
                </h3>
                <div style="border-bottom: 1px solid var(--border); margin-bottom: 1.5rem;"></div>

                <div class="form-grid-2">
                    <div>
                        <label>Cost Price ($)</label>
                        <input type="number" step="0.01" name="cost_price" class="form-control" placeholder="0.00">
                        <small style="color: var(--text-muted);">Price you pay to the supplier.</small>
                    </div>
                    <div>
                        <label>Selling Price ($) <span style="color: var(--danger);">*</span></label>
                        <input type="number" step="0.01" name="sale_price" class="form-control" placeholder="0.00" required>
                        <small style="color: var(--text-muted);">Price charged to customers.</small>
                    </div>
                </div>

                <div style="margin-top: 1.5rem;">
                    <label>Opening Stock Quantity</label>
                    <input type="number" name="qty" class="form-control" value="0" style="max-width: 200px;">
                </div>
            </div>

            <div style="text-align: right; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <button class="btn btn-primary" style="padding: 0.8rem 2.5rem; font-size: 1rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        style="margin-right: 8px;">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Product
                </button>
            </div>
        </form>
    </div>
@endsection