@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Membership</h1>
            <p style="color: var(--text-muted);">Manage customer loyalty and contact info.</p>
        </div>
    </div>

    <div class="card animate-fade">
        <div
            style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; border: 1px dashed var(--border); margin-bottom: 2rem;">
            <h4
                style="margin-bottom: 1rem; font-size: 0.95rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">
                Quick Add Member</h4>
            <form action="{{ route('customers.store') }}" method="POST"
                style="display: grid; grid-template-columns: 2fr 2fr 1fr; gap: 1rem; align-items: start;">
                @csrf
                <div>
                    <input type="text" name="name" class="form-control" placeholder="Customer Name"
                        style="margin-bottom: 0;" required>
                </div>
                <div>
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number"
                        style="margin-bottom: 0;">
                </div>
                <button class="btn btn-primary" style="justify-content: center;">+ Add Member</button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Customer</th>
                    <th>Phone Number</th>
                    <th>Joined Date</th>
                    <th style="text-align: right;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td style="padding-left: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 32px; height: 32px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold;">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <span style="font-weight: 600;">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td style="color: var(--text-muted);">{{ $customer->phone ?? 'N/A' }}</td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>

                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn"
                                    style="padding: 6px; color: var(--secondary);">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn" style="padding: 6px; color: var(--danger);"
                                        onclick="return confirm('Remove member?')">
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