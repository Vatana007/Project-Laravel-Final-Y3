@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Stock History</h1>
            <p style="color: var(--text-muted);">Audit log of all inventory movements.</p>
        </div>
        <a href="{{ route('stock.create') }}" class="btn btn-primary">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                style="margin-right: 8px;">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            Adjust Stock
        </a>
    </div>

    <div class="card animate-fade">
        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Date</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th style="text-align: right;">User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                    <tr>
                        <td style="padding-left: 1.5rem; color: var(--text-muted);">
                            {{ $trx->created_at->format('M d, Y H:i') }}
                        </td>
                        <td style="font-weight: 600;">{{ $trx->product->name ?? 'Deleted Product' }}</td>
                        <td>
                            @if($trx->type == 'in')
                                <span
                                    style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Stock
                                    In</span>
                            @elseif($trx->type == 'broken')
                                <span
                                    style="background: #fee2e2; color: #b91c1c; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Broken</span>
                            @elseif($trx->type == 'sale')
                                <span
                                    style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Sale</span>
                            @else
                                <span
                                    style="background: #f1f5f9; color: var(--text-muted); padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">{{ ucfirst($trx->type) }}</span>
                            @endif
                        </td>
                        <td style="font-weight: bold;">
                            @if($trx->type == 'in' || $trx->type == 'return')
                                <span style="color: var(--success);">+{{ $trx->qty }}</span>
                            @else
                                <span style="color: var(--danger);">-{{ $trx->qty }}</span>
                            @endif
                        </td>
                        <td style="text-align: right; font-size: 0.9rem;">
                            {{ $trx->user->name ?? 'System' }}
                        </td>
                        <td style="text-align: right;">
                            <form action="{{ route('stock.destroy', $trx->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn" style="padding: 4px; color: #cbd5e1;"
                                    onclick="return confirm('Delete this log entry?')">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 1.5rem;">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection