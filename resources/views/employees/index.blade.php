@extends('layout.app')

@section('title', 'Team Management')

@section('content')

    <div class="stats-grid animate-fade">
        <div class="stat-card">
            <div class="stat-content">
                <div>
                    <span class="stat-label">Total Staff</span>
                    <div class="stat-value">{{ $employees->count() }}</div>
                </div>
                <div class="stat-icon" style="background: #e0e7ff; color: var(--primary);">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="stat-card" style="animation-delay: 0.1s;">
            <div class="stat-content">
                <div>
                    <span class="stat-label">Departments</span>
                    <div class="stat-value">{{ $employees->pluck('position_id')->unique()->count() }}</div>
                </div>
                <div class="stat-icon" style="background: #dcfce7; color: #166534;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header animate-fade">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 5px;">Employee Directory</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Manage your staff records and contact details.</p>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary" style="padding: 10px 20px; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 8px;"><path d="M12 4v16m8-8H4"></path></svg>
            Add Employee
        </a>
    </div>

    <div class="card animate-fade" style="padding: 0; overflow: hidden; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
        <div style="overflow-x: auto;">
            <table class="table" style="margin: 0; width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc; border-bottom: 1px solid var(--border);">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; width: 35%;">Employee Name</th>
                        <th style="padding: 1rem; text-align: left;">Job Position</th>
                        <th style="padding: 1rem; text-align: left;">Contact Info</th>
                        <th style="padding: 1rem; text-align: left;">Start Date</th>
                        <th style="padding: 1rem 1.5rem; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody style="background: white;">
                    @forelse($employees as $emp)
                        <tr class="hover-row">
                            
                            <td style="padding: 1rem 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="avatar-circle">
                                        {{ substr($emp->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-main); font-size: 0.95rem;">{{ $emp->name }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">ID: #{{ $emp->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td style="padding: 1rem;">
                                @if($emp->position)
                                    <span style="background: #f1f5f9; color: var(--text-main); padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; border: 1px solid #e2e8f0;">
                                        {{ $emp->position->name }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.85rem; font-style: italic;">Unassigned</span>
                                @endif
                            </td>

                            <td style="padding: 1rem;">
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-size: 0.85rem; color: var(--text-main);">{{ $emp->email }}</span>
                                    <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $emp->phone }}</span>
                                </div>
                            </td>

                            <td style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                                {{ $emp->start_date }}
                            </td>

                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <div style="display: inline-flex; gap: 8px; align-items: center;">
                                    
                                    <a href="{{ route('employees.edit', $emp->id) }}" class="btn-icon edit" title="Edit">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete {{ $emp->name }}? This cannot be undone.');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Delete">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-muted);">
                                <div style="opacity: 0.5; margin-bottom: 10px;">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <p>No employees found.</p>
                                <a href="{{ route('employees.create') }}" style="color: var(--primary); font-weight: 600;">Add your first employee</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem; box-shadow: var(--shadow-sm); }
        .stat-content { display: flex; justify-content: space-between; align-items: start; }
        .stat-label { font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-top: 5px; line-height: 1; }
        .stat-icon { padding: 10px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }

        .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; }

        .hover-row { border-bottom: 1px solid var(--border); transition: background-color 0.15s ease; }
        .hover-row:hover { background-color: #f8fafc; }

        .avatar-circle {
            width: 40px; height: 40px; border-radius: 50%; background: #eff6ff; color: var(--primary);
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem;
            border: 1px solid #e0e7ff;
        }

        .btn-icon {
            width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center;
            border: 1px solid transparent; background: transparent; cursor: pointer; transition: 0.2s;
        }
        .btn-icon.edit { color: var(--secondary); }
        .btn-icon.edit:hover { background: #eff6ff; border-color: #dbeafe; color: var(--primary); }
        
        .btn-icon.delete { color: #cbd5e1; }
        .btn-icon.delete:hover { background: #fef2f2; border-color: #fee2e2; color: var(--danger); }
    </style>

@endsection