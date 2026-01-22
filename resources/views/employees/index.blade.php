@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Team Members</h1>
            <p style="color: var(--text-muted);">Manage employee access and roles.</p>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                style="margin-right: 8px;">
                <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            New Employee
        </a>
    </div>

    <div class="card animate-fade">
        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Employee</th>
                    <th>Role & Salary</th>
                    <th>Contact Info</th>
                    <th>Start Date</th>
                    <th style="text-align: right;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                    <tr>
                        <td style="padding-left: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div
                                    style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #a855f7); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                                    {{ substr($emp->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600;">{{ $emp->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">ID: EMP-00{{ $emp->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500; color: var(--primary);">{{ $emp->position->name ?? 'N/A' }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Base:
                                ${{ number_format($emp->position->base_salary ?? 0, 2) }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.9rem;">{{ $emp->email }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $emp->phone }}</div>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($emp->start_date)->format('M d, Y') }}
                        </td>
                        <td style="text-align: right;">
                            <span
                                style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">Active</span>
                        </td>

                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <a href="{{ route('employees.edit', $emp->id) }}" class="btn"
                                    style="padding: 6px; color: var(--secondary); background: transparent;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn" style="padding: 6px; color: var(--danger); background: transparent;"
                                        onclick="return confirm('Remove employee?')">
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
                @endforeach
            </tbody>
        </table>
    </div>
@endsection