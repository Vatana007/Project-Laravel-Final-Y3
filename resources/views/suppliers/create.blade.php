@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Register Supplier</h1>
            <p style="color: var(--text-muted);">Add a new vendor to your supply chain.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Cancel</a>
    </div>

    <div class="card animate-fade" style="max-width: 700px; margin: 0 auto;">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="form-grid-2">
                <div style="grid-column: span 2;">
                    <label>Company Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Coca-Cola Beverages" required>
                </div>

                <div>
                    <label>Contact Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Office line">
                </div>

                <div>
                    <label>Contact Email (Optional)</label>
                    <input type="email" name="email" class="form-control" placeholder="sales@company.com">
                </div>

                <div style="grid-column: span 2;">
                    <label>Warehouse / Office Address</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Full address details..."></textarea>
                </div>
            </div>

            <div style="text-align: right; margin-top: 1.5rem;">
                <button class="btn btn-primary" style="padding: 0.8rem 2rem;">Save Supplier</button>
            </div>
        </form>
    </div>
@endsection