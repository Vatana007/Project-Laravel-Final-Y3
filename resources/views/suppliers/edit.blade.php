@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Edit Supplier</h1>
            <p style="color: var(--text-muted);">Update contact information for: <strong>{{ $supplier->name }}</strong></p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border); color: var(--text-main);">
            Cancel
        </a>
    </div>

    <div class="card animate-fade" style="max-width: 600px;">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h3
                style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                Supplier Details</h3>

            <div style="margin-bottom: 1.5rem;">
                <label>Company / Supplier Name</label>
                <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
            </div>

            <div class="form-grid-2">
                <div>
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}">
                </div>
                <div>
                    <label>Location / City</label>
                    <input type="text" class="form-control" disabled value="Main HQ"
                        style="background: #f1f5f9; cursor: not-allowed;">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label>Full Address</label>
                <textarea name="address" class="form-control" rows="3"
                    style="font-family: inherit;">{{ $supplier->address }}</textarea>
            </div>

            <div style="text-align: right; margin-top: 2rem;">
                <button class="btn btn-primary" style="padding: 0.8rem 2rem;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        style="margin-right: 6px;">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Supplier
                </button>
            </div>
        </form>
    </div>
@endsection