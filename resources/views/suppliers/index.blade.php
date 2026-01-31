@extends('layout.app')

@section('title', 'Suppliers')

@section('content')

    <div class="animate-fade" style="max-width: 1200px; margin: 0 auto;">

        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0;">Supplier Directory</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 5px;">Manage vendor contacts and
                    sourcing.</p>
            </div>
            <a href="{{ route('suppliers.create') }}" class="btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Add Supplier
            </a>
        </div>

        <div class="grid-container">
            @forelse($suppliers as $supplier)
                <div class="vendor-card">

                    <div class="card-header">
                        <div class="company-logo">
                            {{ substr($supplier->name, 0, 1) }}
                        </div>
                        <div class="actions">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="icon-btn edit" title="Edit">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                onsubmit="return confirm('Delete this supplier?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn delete" title="Delete">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="company-name">{{ $supplier->name }}</h3>
                        <div class="contact-person">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Rep: {{ $supplier->contact_person ?? 'N/A' }}
                        </div>

                        <div class="divider"></div>

                        <div class="info-group">
                            <div class="info-row">
                                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $supplier->phone ?? '-' }}
                            </div>
                            <div class="info-row">
                                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $supplier->email ?? '-' }}
                            </div>
                            <div class="info-row address">
                                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ Str::limit($supplier->address, 30) ?? 'No Address' }}
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3>No Suppliers Found</h3>
                    <p>Register your vendors to track inventory sources.</p>
                    <a href="{{ route('suppliers.create') }}" class="link-btn">Add First Supplier</a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        /* Grid */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* Card */
        .vendor-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: 0.2s;
            position: relative;
            overflow: hidden;
        }

        .vendor-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .card-header {
            padding: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: start;
            background: linear-gradient(to bottom, #f8fafc, #fff);
            border-bottom: 1px dashed #f1f5f9;
        }

        .company-logo {
            width: 42px;
            height: 42px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: var(--text-main);
            font-size: 1.2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        .icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
        }

        .icon-btn.edit:hover {
            background: #eff6ff;
            color: var(--primary);
            border-color: #dbeafe;
        }

        .icon-btn.delete:hover {
            background: #fef2f2;
            color: var(--danger);
            border-color: #fee2e2;
        }

        .card-body {
            padding: 1.25rem;
        }

        .company-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 4px 0;
        }

        .contact-person {
            font-size: 0.85rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .divider {
            height: 1px;
            background: #f1f5f9;
            margin: 1rem 0;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .info-row.address {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .icon {
            width: 16px;
            height: 16px;
            color: #94a3b8;
        }

        .btn-primary {
            background: var(--text-main);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem;
            background: white;
            border: 1px dashed var(--border);
            border-radius: 12px;
        }

        .empty-icon {
            color: var(--primary);
            opacity: 0.5;
            margin-bottom: 1rem;
        }

        .link-btn {
            color: var(--primary);
            font-weight: 600;
            margin-top: 1rem;
            display: inline-block;
            text-decoration: none;
        }

        .link-btn:hover {
            text-decoration: underline;
        }
    </style>
@endsection