@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Stock Inventory Report</h1>
            <p style="color: var(--text-muted);">Real-time overview of product quantities and valuation.</p>
        </div>
        <div class="btn" style="background: white; border: 1px solid var(--border); cursor: default;">
            Total Items: <strong>{{ \App\Models\Product::count() }}</strong>
        </div>
    </div>

    <div class="animate-fade"
        style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="stat-card">
            <span class="stat-label">Total Stock Value (Cost)</span>
            <div class="stat-value" style="color: var(--primary);">
                ${{ number_format(\App\Models\Product::sum(\Illuminate\Support\Facades\DB::raw('cost_price * qty')), 2) }}
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Potential Revenue (Sale)</span>
            <div class="stat-value" style="color: var(--success);">
                ${{ number_format(\App\Models\Product::sum(\Illuminate\Support\Facades\DB::raw('sale_price * qty')), 2) }}
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Low Stock Alerts</span>
            <div class="stat-value" style="color: var(--danger);">
                {{ \App\Models\Product::where('qty', '<=', 5)->count() }}
            </div>
            <div style="font-size: 0.8rem; color: var(--danger);">Items below 5 qty</div>
        </div>
    </div>

    <div class="card animate-fade">
        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Product</th>
                    <th>Category</th>
                    <th>Stock Level</th>
                    <th style="text-align: right;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Product::orderBy('qty', 'asc')->get() as $product)
                    <tr>
                        <td style="padding-left: 1.5rem;">
                            <div style="font-weight: 600;">{{ $product->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $product->barcode }}</div>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td style="width: 40%;">
                            <div
                                style="height: 8px; width: 100%; background: #f1f5f9; border-radius: 4px; overflow: hidden; max-width: 200px;">
                                @php 
                                                            $percent = min($product->qty, 100);
                                    $color = $product->qty <= 5 ? '#ef4444' : ($product->qty < 20 ? '#f59e0b' : '#10b981');
                                @endphp
                                <div style="height: 100%; width: {{ $percent }}%; background: {{ $color }};"></div>
                            </div>
                    </td>
                        <td style="text-align: right;">
                        @if($product->qty <= 5)
                            <span style="color: var(--danger); font-weight: 700;">{{ $product->qty }} Units</span>
                        @else
                                <span style="font-weight: 600;">{{ $product->qty }} Units</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection