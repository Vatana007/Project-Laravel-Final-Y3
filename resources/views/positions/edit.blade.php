@extends('layout.app')
@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Edit Position</h1>
        </div>
        <a href="{{ route('positions.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Back</a>
    </div>
    <div class="card animate-fade" style="max-width: 500px; margin: 0 auto;">
        <form action="{{ route('positions.update', $position->id) }}" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom: 1rem;">
                <label>Position Name</label>
                <input type="text" name="name" class="form-control" value="{{ $position->name }}" required>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label>Base Salary</label>
                <input type="number" step="0.01" name="base_salary" class="form-control"
                    value="{{ $position->base_salary }}" required>
            </div>
            <button class="btn btn-primary" style="width: 100%; justify-content: center;">Update Position</button>
        </form>
    </div>
@endsection