@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Job Positions</h1>
            <p style="color: var(--text-muted);">Define employee roles and base salaries.</p>
        </div>
    </div>

    <div class="pos-container animate-fade">
        <div class="card" style="height: fit-content;">
            <h3
                style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Add New Position
            </h3>

            <form action="{{ route('positions.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label>Position Title</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Store Manager" required>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label>Base Salary ($)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 10px; color: var(--text-muted);">$</span>
                        <input type="number" step="0.01" name="base_salary" class="form-control" style="padding-left: 25px;"
                            placeholder="0.00" required>
                    </div>
                </div>

                <button class="btn btn-primary" style="width: 100%; justify-content: center;">Save Position</button>
            </form>
        </div>

        <div class="card">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Current Roles</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th style="padding-left: 1.5rem;">Role Name</th>
                        <th>Base Salary</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $pos)
                        <tr>
                            <td style="padding-left: 1.5rem; font-weight: 600;">{{ $pos->name }}</td>
                            <td>
                                <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-weight: 500;">
                                    ${{ number_format($pos->base_salary, 2) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="{{ route('positions.edit', $pos->id) }}" class="btn"
                                        style="padding: 6px; color: var(--secondary);">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('positions.destroy', $pos->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn" style="padding: 6px; color: var(--danger);"
                                            onclick="return confirm('Delete this position?')">
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
    </div>
@endsection