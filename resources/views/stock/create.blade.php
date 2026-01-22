@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Adjust Stock</h1>
            <p style="color: var(--text-muted);">Record new shipments or damaged goods.</p>
        </div>
        <a href="{{ route('stock.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">History</a>
    </div>

    <div class="card animate-fade" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('stock.store') }}" method="POST">
            @csrf

            <div
                style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--border); margin-bottom: 2rem;">
                <label>Select Product</label>
                <select name="product_id" class="form-control" style="font-size: 1rem;">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} (Current: {{ $product->qty }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grid-2">
                <div>
                    <label>Transaction Type</label>
                    <select name="type" class="form-control">
                        <option value="in">📥 Stock In (Restock)</option>
                        <option value="broken">🔥 Damaged / Broken</option>
                        <option value="return">↩️ Customer Return</option>
                        <option value="out">📤 Stock Out (Manual)</option>
                    </select>
                </div>
                <div>
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control" placeholder="0" min="1" required>
                </div>
            </div>

            <label>Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="2" placeholder="Reason for adjustment..."></textarea>

            <button class="btn btn-primary" style="width: 100%; margin-top: 1rem; justify-content: center;">
                Confirm Adjustment
            </button>
        </form>
    </div>
@endsection