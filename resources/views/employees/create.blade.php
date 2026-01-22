@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Onboard Employee</h1>
            <p style="color: var(--text-muted);">Register a new staff member to the system.</p>
        </div>
        <a href="{{ route('employees.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Cancel</a>
    </div>

    <div class="card animate-fade" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="form-grid-2">
                <div>
                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--primary);">Personal
                        Details</h4>
                    <div
                        style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--border);">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>

                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@company.com" required>

                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+855 12 345 678" required>
                    </div>
                </div>

                <div>
                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--primary);">Job
                        Information</h4>
                    <div
                        style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--border);">
                        <label>Position / Role</label>
                        <select name="position_id" class="form-control">
                            @foreach(\App\Models\Position::all() as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->name }} (Base: ${{ $pos->base_salary }})</option>
                            @endforeach
                        </select>

                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <div style="margin-top: 2rem; text-align: right;">
                <button class="btn btn-primary" style="padding: 0.8rem 2rem;">Confirm Onboarding</button>
            </div>
        </form>
    </div>
@endsection