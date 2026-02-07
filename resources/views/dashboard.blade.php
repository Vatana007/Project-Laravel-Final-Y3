@extends('layout.app')

@section('title', 'Overview')

@section('content')

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    
    <div class="card" style="border-left: 4px solid var(--primary); padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 50px; height: 50px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Today's Revenue</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">${{ number_format($todayRevenue, 2) }}</div>
        </div>
    </div>

    <div class="card" style="border-left: 4px solid var(--success); padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 50px; height: 50px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--success);">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Total Orders</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">{{ number_format($totalOrders) }}</div>
        </div>
    </div>

    <div class="card" style="border-left: 4px solid #6366f1; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 50px; height: 50px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6366f1;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Total Members</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">{{ number_format($totalMembers) }}</div>
        </div>
    </div>

    <div class="card" style="border-left: 4px solid var(--danger); padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--danger);">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Low Stock Items</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">{{ $lowStockItems }}</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    
    <div class="card animate-fade">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main);">Recent Sales</h3>
            <a href="{{ route('reports.sales') }}" class="btn" style="background: #f1f5f9; color: var(--text-muted); font-size: 0.8rem;">View All</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1rem;">Receipt #</th>
                    <th>Date</th>
                    <th>Cashier</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td style="padding-left: 1rem; font-family: monospace; font-weight: 600;">#{{ 1000 + $sale->id }}</td>
                    <td style="color: var(--text-muted);">{{ $sale->created_at->format('M d, H:i') }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 24px; height: 24px; background: #e0e7ff; color: var(--primary); border-radius: 50%; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ substr($sale->user->name ?? 'A', 0, 1) }}
                            </div>
                            <span>{{ $sale->user->name ?? 'Admin' }}</span>
                        </div>
                    </td>
                    <td style="text-align: right; font-weight: 700; color: var(--success);">${{ number_format($sale->final_total, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">No sales recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card animate-fade">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">Recent Activity</h3>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($recentStock as $stock)
            <div style="display: flex; gap: 12px; padding-bottom: 1rem; border-bottom: 1px dashed var(--border);">
                <div style="margin-top: 2px;">
                    @if($stock->type == 'in')
                        <div style="width: 32px; height: 32px; background: #dcfce7; color: #166534; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    @elseif($stock->type == 'out' || $stock->type == 'broken')
                        <div style="width: 32px; height: 32px; background: #fee2e2; color: #b91c1c; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12H4"></path></svg>
                        </div>
                    @else
                        <div style="width: 32px; height: 32px; background: #f1f5f9; color: var(--text-muted); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    @endif
                </div>
                
                <div style="flex: 1;">
                    <div style="font-weight: 600; font-size: 0.9rem;">
                        {{ ucfirst($stock->type) }} Adjustment
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; margin: 2px 0;">
                        {{ $stock->product->name ?? 'Unknown Item' }}
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-main);">
                        @if($stock->type == 'in')
                            <span style="color: var(--success); font-weight: 700;">+{{ $stock->qty }}</span> added
                        @else
                            <span style="color: var(--danger); font-weight: 700;">-{{ $stock->qty }}</span> removed
                        @endif
                    </div>
                </div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-align: right;">
                    {{ $stock->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div style="text-align: center; color: var(--text-muted); padding: 1rem;">No activity found.</div>
            @endforelse
        </div>
        
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('stock.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                Adjust Stock
            </a>
        </div>
    </div>
</div>

@endsection