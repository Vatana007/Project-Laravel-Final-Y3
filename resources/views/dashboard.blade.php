@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Dashboard Overview</h1>
            <p style="color: var(--text-muted); margin-top: 4px;">
                Good afternoon, <strong>{{ auth()->user()->name }}</strong>. Here is what's happening today.
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('pos.index') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 1rem;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    style="margin-right: 8px;">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                New Sale (POS)
            </a>
        </div>
    </div>

    <div class="animate-fade"
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <span class="stat-label">Total Revenue</span>
                    <div class="stat-value" style="color: var(--primary);">${{ number_format($totalSales, 2) }}</div>
                </div>
                <div style="background: #e0e7ff; color: var(--primary); padding: 10px; border-radius: 10px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"></path>
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; display: flex; align-items: center; font-size: 0.85rem; color: var(--success);">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    style="margin-right: 4px;">
                    <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span>+12.5% from last month</span>
            </div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <span class="stat-label">Today's Sales</span>
                    <div class="stat-value">${{ number_format($todaySales, 2) }}</div>
                </div>
                <div style="background: #d1fae5; color: #059669; padding: 10px; border-radius: 10px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.85rem; color: var(--text-muted);">
                Updated just now
            </div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <span class="stat-label">Low Stock Items</span>
                    <div class="stat-value" style="color: var(--danger);">{{ $lowStockProducts }}</div>
                </div>
                <div style="background: #fee2e2; color: var(--danger); padding: 10px; border-radius: 10px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01">
                        </path>
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.85rem; color: var(--danger);">
                Requires attention
            </div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <span class="stat-label">Total Staff</span>
                    <div class="stat-value">{{ $totalEmployees }}</div>
                </div>
                <div style="background: #f1f5f9; color: var(--secondary); padding: 10px; border-radius: 10px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.85rem; color: var(--text-muted);">
                Active members
            </div>
        </div>
    </div>

    <div class="animate-fade" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; animation-delay: 0.1s;">

        <div class="card" style="min-height: 400px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.2rem; font-weight: 700;">Recent Sales Performance</h3>
                <select class="form-control"
                    style="width: auto; padding: 0.4rem 2rem 0.4rem 0.8rem; margin: 0; font-size: 0.85rem;">
                    <option>Last 7 Days</option>
                    <option>This Month</option>
                </select>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="padding-left: 0;">Date</th>
                        <th>Revenue</th>
                        <th>Trend</th>
                        <th style="text-align: right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesData as $data)
                        <tr>
                            <td style="padding-left: 0; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($data->date)->format('M d, Y') }}
                            </td>
                            <td>${{ number_format($data->total, 2) }}</td>
                            <td>
                                <div
                                    style="width: 100px; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                    <div style="width: {{ rand(40, 90) }}%; height: 100%; background: var(--primary);"></div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span
                                    style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                                    Completed
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">

            <div class="card"
                style="background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; border: none;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: white;">Quick Actions</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <a href="{{ route('products.create') }}"
                        style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px; text-align: center; color: white; transition: 0.2s;">
                        <div style="font-size: 1.5rem; margin-bottom: 5px;">📦</div>
                        <div style="font-size: 0.8rem; font-weight: 600;">Add Product</div>
                    </a>
                    <a href="{{ route('customers.index') }}"
                        style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px; text-align: center; color: white; transition: 0.2s;">
                        <div style="font-size: 1.5rem; margin-bottom: 5px;">👥</div>
                        <div style="font-size: 0.8rem; font-weight: 600;">Add Member</div>
                    </a>
                </div>
            </div>

            <div class="card">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.25rem;">System Activity</h3>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div
                        style="background: #e0e7ff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: bold; flex-shrink: 0;">
                        S
                    </div>
                    <div>
                        <div style="font-size: 0.9rem; font-weight: 500;">System Update</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Database backup completed successfully.
                        </div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">2 hours ago</div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div
                        style="background: #fee2e2; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--danger); font-weight: bold; flex-shrink: 0;">
                        !
                    </div>
                    <div>
                        <div style="font-size: 0.9rem; font-weight: 500;">Stock Alert</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Coca Cola inventory is running low
                            ({{ $lowStockProducts }} items).</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">5 hours ago</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection