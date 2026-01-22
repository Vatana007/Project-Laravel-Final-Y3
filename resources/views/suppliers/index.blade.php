@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Supplier Management</h1>
            <p style="color: var(--text-muted);">Track vendors and source contact information.</p>
        </div>
    </div>

    <div class="card animate-fade">
        <div
            style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--border); margin-bottom: 2rem;">
            <h4
                style="margin-bottom: 1rem; font-size: 0.9rem; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Register New Supplier
            </h4>

            <form action="{{ route('suppliers.store') }}" method="POST"
                style="display: grid; grid-template-columns: 1.5fr 1fr 2fr auto; gap: 1rem; align-items: start;">
                @csrf
                <div>
                    <input type="text" name="name" class="form-control" placeholder="Company Name *"
                        style="margin-bottom: 0;" required>
                </div>
                <div>
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number"
                        style="margin-bottom: 0;">
                </div>
                <div>
                    <input type="text" name="address" class="form-control" placeholder="Address / Location"
                        style="margin-bottom: 0;">
                </div>
                <button class="btn btn-primary" style="height: 42px; padding: 0 1.5rem;">
                    Save
                </button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="padding-left: 1.5rem;">Company / Name</th>
                    <th>Contact Info</th>
                    <th>Location</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $sup)
                    <tr>
                        <td style="padding-left: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 40px; height: 40px; background: white; border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--secondary);">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div style="font-weight: 600; color: var(--text-main);">{{ $sup->name }}</div>
                            </div>
                        </td>
                        <td>
                            @if($sup->phone)
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.9rem;">
                                    <svg width="14" height="14" fill="none" stroke="var(--text-muted)" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ $sup->phone }}
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.9rem;">
                            {{ \Illuminate\Support\Str::limit($sup->address, 40) ?? 'N/A' }}
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 4px;">
                                <a href="{{ route('suppliers.edit', $sup->id) }}" class="btn"
                                    style="padding: 6px; color: var(--secondary); background: transparent; border: 1px solid transparent;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                <form action="{{ route('suppliers.destroy', $sup->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn"
                                        style="padding: 6px; color: var(--danger); background: transparent; border: 1px solid transparent;"
                                        onclick="return confirm('Remove this supplier permanently?')">
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