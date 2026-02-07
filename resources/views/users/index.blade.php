@extends('layout.app')

@section('title', 'User Management')

@section('content')

    <div class="header animate-fade">
        <div>
            <h1 class="page-title">User Management</h1>
            <p style="color: var(--text-muted);">Manage employee access and system roles.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            Add New User
        </a>
    </div>

    <div class="card animate-fade" style="margin-top: 2rem; background: white; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm);">
        <table class="table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">User Name</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Email (Login ID)</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Role</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Created At</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 1rem 1.5rem;">
                            <div style="font-weight: 600; color: var(--text-main);">{{ $user->name }}</div>
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted);">{{ $user->email }}</td>
                        <td style="padding: 1rem;">
                            @if($user->role === 'admin')
                                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Admin</span>
                            @elseif($user->role === 'staff')
                                <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Staff</span>
                            @else
                                <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">User</span>
                            @endif
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td style="padding: 1rem 1.5rem; text-align: right;">
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #ef4444; padding: 4px;" title="Delete User">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.8rem; color: #cbd5e1; font-style: italic;">(You)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .header { display: flex; justify-content: space-between; align-items: flex-end; }
        .page-title { font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.2s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }
        tr:last-child { border-bottom: none; }
        tr:hover td { background: #fcfcfc; }
    </style>

@endsection