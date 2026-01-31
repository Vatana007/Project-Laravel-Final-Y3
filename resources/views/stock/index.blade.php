@extends('layout.app')

@section('title', 'Stock History')

@section('content')

    <div class="card animate-fade" style="border: none; box-shadow: var(--shadow-md);">

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 4px;">Stock
                    Adjustments</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Track every inventory movement manually recorded.
                </p>
            </div>

            <a href="{{ route('stock.create') }}" class="btn btn-primary"
                style="padding: 0.7rem 1.2rem; font-weight: 600; border-radius: 8px; font-size: 0.9rem;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    style="margin-right: 6px;">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                New Adjustment
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="table" style="vertical-align: middle;">
                <thead>
                    <tr
                        style="background: #f8fafc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);">
                        <th style="padding: 1rem; border-top-left-radius: 8px;">Date & Time</th>
                        <th>Product Item</th>
                        <th>User / Staff</th>
                        <th>Type</th>
                        <th style="text-align: right;">Quantity</th>
                        <th style="width: 20%;">Reason / Note</th>
                        <th style="padding: 1rem; border-top-right-radius: 8px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $log)
                        <tr class="hover-row" style="transition: background 0.2s; border-bottom: 1px solid var(--border);">

                            <td style="padding: 1rem;">
                                <div style="font-weight: 600; color: var(--text-main);">{{ $log->created_at->format('M d, Y') }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">
                                    {{ $log->created_at->format('h:i A') }}</div>
                            </td>

                            <td>
                                <div style="font-weight: 600; color: var(--text-main);">
                                    {{ $log->product->name ?? 'Deleted Item' }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">SKU:
                                    {{ $log->product->barcode ?? 'N/A' }}</div>
                            </td>

                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div
                                        style="width: 28px; height: 28px; background: #e0e7ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                        {{ substr($log->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span style="font-size: 0.9rem;">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </td>

                            <td>
                                @if($log->type == 'in')
                                    <span class="badge badge-in">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3"
                                            viewBox="0 0 24 24">
                                            <path d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        Stock In
                                    </span>
                                @else
                                    <span class="badge badge-out">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3"
                                            viewBox="0 0 24 24">
                                            <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                        Stock Out
                                    </span>
                                @endif
                            </td>

                            <td style="text-align: right; font-weight: 700; font-family: monospace; font-size: 1rem;">
                                @if($log->type == 'in')
                                    <span style="color: var(--success);">+{{ $log->qty }}</span>
                                @else
                                    <span style="color: var(--danger);">-{{ $log->qty }}</span>
                                @endif
                            </td>

                            <td style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">
                                {{ $log->note ?? '-' }}
                            </td>

                            <td style="text-align: right; padding: 1rem;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="{{ route('stock.edit', $log->id) }}" class="btn-icon"
                                        style="color: var(--secondary);" title="Edit">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('stock.destroy', $log->id) }}" method="POST" style="display: inline;"
                                        onsubmit="return confirm('WARNING: Deleting this log will REVERSE the stock change on the product. Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon"
                                            style="color: var(--danger); background: none; border: none; cursor: pointer;"
                                            title="Delete">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
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
                            <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                <div style="margin-bottom: 1rem; opacity: 0.5;">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                                <p>No adjustments recorded yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .hover-row:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-in {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-out {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Action Buttons */
        .btn-icon {
            padding: 6px;
            border-radius: 6px;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: #e2e8f0;
        }
    </style>

@endsection