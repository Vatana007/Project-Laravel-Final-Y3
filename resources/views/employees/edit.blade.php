@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Edit Employee</h1>
            <p style="color: var(--text-muted);">Update profile for: <strong>{{ $employee->name }}</strong></p>
        </div>
        <a href="{{ route('employees.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Back</a>
    </div>

    <div class="card animate-fade" style="max-width: 800px;">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div>
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                </div>
                <div>
                    <label>Position</label>
                    <select name="position_id" class="form-control">
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ $employee->position_id == $pos->id ? 'selected' : '' }}>
                                {{ $pos->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div>
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
                </div>
                <div>
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
                </div>
            </div>

            <div>
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $employee->start_date }}">
            </div>

            <div style="margin-top: 2rem; text-align: right;">
                <button class="btn btn-primary" style="padding: 0.8rem 2rem;">Save Changes</button>
            </div>
        </form>
    </div>
@endsection