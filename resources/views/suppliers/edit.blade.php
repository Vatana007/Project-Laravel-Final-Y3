@extends('layout.app')

@section('title', 'Edit Supplier')

@section('content')

    <div class="animate-fade" style="max-width: 750px; margin: 3rem auto;">

        <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0;">Edit Supplier</h1>
            <a href="{{ route('suppliers.index') }}" class="btn-cancel">Back</a>
        </div>

        <div class="card-form">
            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-section">
                    <h3 class="section-label">Company Profile</h3>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="name" class="modern-input" value="{{ $supplier->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="modern-input" value="{{ $supplier->address }}">
                    </div>
                </div>

                <div class="divider"></div>

                <div class="form-section">
                    <h3 class="section-label">Contact Details</h3>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input type="text" name="contact_person" class="modern-input"
                                value="{{ $supplier->contact_person }}">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="modern-input" value="{{ $supplier->phone }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="modern-input" value="{{ $supplier->email }}">
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-save">Update Supplier</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Reuse styles from Create page */
        .card-form {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .form-section {
            padding: 2rem;
        }

        .section-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            letter-spacing: 0.05em;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .modern-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.95rem;
            transition: 0.2s;
        }

        .modern-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .divider {
            height: 1px;
            background: #f1f5f9;
            width: 100%;
        }

        .form-footer {
            background: #f8fafc;
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border);
            text-align: right;
        }

        .btn-save {
            background: var(--text-main);
            color: white;
            padding: 10px 24px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-save:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        .btn-cancel {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 6px;
            background: #f1f5f9;
            transition: 0.2s;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            color: var(--text-main);
        }
    </style>

@endsection