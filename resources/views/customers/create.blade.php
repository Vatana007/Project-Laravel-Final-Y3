@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">New Member</h1>
            <p style="color: var(--text-muted);">Create a customer profile for loyalty tracking.</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn"
            style="background: white; border: 1px solid var(--border);">Cancel</a>
    </div>

    <div class="card animate-fade" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div style="text-align: center; margin-bottom: 2rem;">
                <div
                    style="width: 80px; height: 80px; background: #e0e7ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 700;">Customer Profile</h3>
            </div>

            <label>Customer Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>

            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="Mobile number for points">

            <button class="btn btn-primary"
                style="width: 100%; margin-top: 1.5rem; justify-content: center; padding: 0.8rem;">
                Create Member Account
            </button>
        </form>
    </div>
@endsection