@extends('layout.app')

@section('title', 'Sales Report')

@section('content')

    <div class="animate-fade" style="max-width: 1200px; margin: 0 auto;">

        <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <h1 class="page-title">Sales Overview</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Daily revenue and transaction
                    history.</p>
            </div>

            <form action="{{ route('reports.sales') }}" method="GET" class="filter-group">
                <input type="date" name="start_date" class="date-input" value="{{ request('start_date', date('Y-m-d')) }}">
                <span style="color: #94a3b8; font-size: 0.9rem;">to</span>
                <input type="date" name="end_date" class="date-input" value="{{ request('end_date', date('Y-m-d')) }}">

                <button type="submit" class="btn-filter">Filter</button>

                <button type="submit" formaction="{{ route('reports.sales.print') }}" formtarget="_blank" class="btn-print">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        style="margin-right: 6px;">
                        <path
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print
                </button>
            </form>
        </div>

        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Transactions</div>
                    <div class="stat-value">{{ $totalTransactions }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Cash Sales</div>
                    <div class="stat-value">${{ number_format($cashSales, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="report-card">
            <div style="overflow-x: auto;">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th style="padding-left: 1.5rem;">Invoice #</th>
                            <th>Date & Time</th>
                            <th>Customer</th>
                            <th>Cashier</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th style="text-align: right; padding-right: 1.5rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="invoice-id" style="padding-left: 1.5rem;">{{ $sale->invoice_number }}</td>
                                <td style="color: var(--text-muted); font-size: 0.9rem;">
                                    {{ $sale->created_at->format('M d, Y • H:i') }}
                                </td>
                                <td>
                                    @if($sale->customer)
                                        <span style="font-weight: 600; color: var(--text-main);">{{ $sale->customer->name }}</span>
                                    @else
                                        <span style="color: var(--text-muted); font-style: italic;">Walk-in</span>
                                    @endif
                                </td>
                                <td>{{ $sale->user->name ?? 'Unknown' }}</td>
                                <td>
                                    <span class="badge">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </td>
                                <td style="font-weight: 700; color: var(--text-main);">
                                    ${{ number_format($sale->final_total, 2) }}
                                </td>
                                <td style="text-align: right; padding-right: 1.5rem;">
                                    <div style="display: inline-flex; gap: 8px; align-items: center;">
                                        <a href="{{ route('reports.invoice', $sale->id) }}" target="_blank"
                                            class="btn-action print" title="Print Invoice">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="margin:0;"
                                            onsubmit="return confirm('Delete this record? This cannot be undone.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Delete">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
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
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 4rem; color: var(--text-muted);">
                                    No sales transactions found for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        /* Header & Filters */
        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -0.01em;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 8px 8px;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
        }

        .date-input {
            border: none;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-main);
            outline: none;
        }

        .btn-filter {
            background: var(--text-main);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.85rem;
        }

        .btn-filter:hover {
            background: var(--primary);
        }

        /* NEW: Print Button Style */
        .btn-print {
            background: #e0e7ff;
            color: var(--primary);
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
        }

        .btn-print:hover {
            background: #c7d2fe;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            text-align: center;
        }

        .stat-card.primary .stat-icon {
            background: var(--primary);
            color: white;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: #f1f5f9;
            color: var(--text-muted);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Report Table */
        .report-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }

        .report-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .report-table tr:hover td {
            background: #fcfcfc;
        }

        .invoice-id {
            font-family: monospace;
            font-weight: 700;
            color: var(--primary);
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            background: #f1f5f9;
            color: var(--text-muted);
            border: 1px solid #e2e8f0;
        }

        /* Actions */
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
            transition: 0.2s;
            color: var(--text-muted);
        }

        .btn-action.print:hover {
            background: #e0e7ff;
            color: var(--primary);
        }

        .btn-action.delete:hover {
            background: #fef2f2;
            color: var(--danger);
        }
    </style>

@endsection