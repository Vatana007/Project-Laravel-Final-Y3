@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Sales Report</h1>
            <p style="color: var(--text-muted);">Analyze your transaction history.</p>
        </div>
        <form action="{{ route('reports.sales') }}" method="GET"
            style="display: flex; gap: 10px; background: white; padding: 5px; border-radius: 8px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <input type="date" name="start_date" class="form-control" style="margin:0; border:none; width: auto;"
                value="{{ request('start_date') }}">
            <span style="align-self: center; color: var(--text-muted);">to</span>
            <input type="date" name="end_date" class="form-control" style="margin:0; border:none; width: auto;"
                value="{{ request('end_date') }}">
            <button class="btn btn-primary" style="border-radius: 6px;">Filter</button>
        </form>
    </div>

    <div class="animate-fade"
        style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="stat-card">
            <span class="stat-label">Total Revenue</span>
            <div class="stat-value" style="color: var(--primary);">${{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Transactions</span>
            <div class="stat-value">{{ $sales->count() }}</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Average Order Value</span>
            <div class="stat-value" style="color: var(--success);">
                ${{ $sales->count() > 0 ? number_format($totalRevenue / $sales->count(), 2) : '0.00' }}
            </div>
        </div>
    </div>

    <div class="card animate-fade">
        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Invoice ID</th>
                    <th>Date & Time</th>
                    <th>Cashier</th>
                    <th>Payment Method</th>
                    <th style="text-align: right;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td style="padding-left: 1.5rem; font-family: monospace; font-weight: 600; color: var(--primary);">
                            {{ $sale->invoice_number }}
                        </td>
                        <td>
                            {{ $sale->created_at->format('M d, Y') }}
                            <span
                                style="color: var(--text-muted); font-size: 0.8rem; margin-left: 5px;">{{ $sale->created_at->format('H:i') }}</span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div
                                    style="width: 24px; height: 24px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: var(--primary); font-weight: bold;">
                                    {{ substr($sale->user->name, 0, 1) }}
                                </div>
                                {{ $sale->user->name }}
                            </div>
                        </td>
                        <td>
                            <span
                                style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--border);">
                                {{ $sale->payment_type }}
                            </span>
                        </td>
                        <td style="text-align: right; font-weight: 700;">
                            ${{ number_format($sale->final_total, 2) }}
                        </td>

                        <td style="text-align: right;">
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn" style="padding: 4px; color: var(--text-muted); hover:text-red-500;"
                                    onclick="return confirm('Delete this sale record?')">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection