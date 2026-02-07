@extends('layout.app')

@section('title', 'Create User')

@section('content')

    <div style="max-width: 600px; margin: 2rem auto;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Create New User</h1>
            <p style="color: var(--text-muted);">Add a new employee access account.</p>
        </div>

        <div class="card animate-fade"
            style="background: white; padding: 2.5rem; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">Full
                        Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required autofocus>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">Email
                        Address (Login ID)</label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. john@pos.com" required>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="******" required>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">Access
                        Role</label>
                    <div style="position: relative;">
                        <select name="role" class="form-control" style="appearance: none; background: #f8fafc;">
                            <option value="user">User (POS Only)</option>
                            <option value="staff">Staff (POS, Inventory, Members)</option>
                            <option value="admin">Admin (Full Control)</option>
                        </select>
                        <div style="position: absolute; right: 15px; top: 12px; pointer-events: none; color: #94a3b8;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px;">
                        <strong>User:</strong> Can only sell.<br>
                        <strong>Staff:</strong> Can sell, add stock, manage members.<br>
                        <strong>Admin:</strong> Can do everything.
                    </p>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('users.index') }}" class="btn"
                        style="flex: 1; background: white; border: 1px solid var(--border); color: var(--text-main); justify-content: center;">Cancel</a>
                    <button type="submit" class="btn btn-primary"
                        style="flex: 2; justify-content: center; padding: 0.8rem;">Create Account</button>
                </div>

            </form>
        </div>
    </div>

@endsection