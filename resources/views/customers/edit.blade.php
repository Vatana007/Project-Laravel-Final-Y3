@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Edit Member</h1>
        </div>
        <a href="{{ route('customers.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Cancel</a>
    </div>

    <div class="card animate-fade" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-grid-2">
                <div>
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                </div>
                <div>
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                </div>
            </div>

            <button class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">Save
                Changes</button>
        </form>
    </div>
@endsection