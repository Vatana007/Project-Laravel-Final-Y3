@extends('layout.app')

@section('title', 'Register Member')

@section('content')

    <div class="animate-fade" style="max-width: 600px; margin: 3rem auto;">

        <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0;">New Member</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Register a new customer.</p>
            </div>
            <a href="{{ route('customers.index') }}" class="btn-close">Cancel</a>
        </div>

        <div class="card-form">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="modern-input" placeholder="e.g. Sarah Connor" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="modern-input" placeholder="+1 234 567" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="modern-input" placeholder="Optional">
                    </div>
                </div>

                <div class="form-group">
                    <label>Address / Location</label>
                    <input type="text" name="address" class="modern-input" placeholder="City, State">
                </div>

                <button type="submit" class="btn-submit">Save Member</button>
            </form>
        </div>
    </div>

    <style>
        .card-form {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
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
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: 0.2s;
        }

        .modern-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-close {
            color: var(--text-muted);
            font-weight: 600;
            text-decoration: none;
            background: #f1f5f9;
            padding: 8px 16px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-close:hover {
            background: #e2e8f0;
            color: var(--text-main);
        }
    </style>

@endsection