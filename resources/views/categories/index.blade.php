@extends('layout.app')

@section('content')
    <div class="header animate-fade">
        <div>
            <h1 class="page-title">Product Categories</h1>
            <p style="color: var(--text-muted);">Organize your products for the POS.</p>
        </div>
    </div>

    <div class="pos-container animate-fade">
        <div class="card" style="height: fit-content;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem;">Create Category</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <label>Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Beverages" required>

                <button class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        style="margin-right: 6px;">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                    Save Category
                </button>
            </form>
        </div>

        <div class="card">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Existing Categories</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th style="padding-left: 1.5rem;">Name</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                        <tr>
                            <td style="padding-left: 1.5rem; font-weight: 500;">{{ $cat->name }}</td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="{{ route('categories.edit', $cat->id) }}" class="btn"
                                        style="padding: 6px; color: var(--secondary);">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn" style="padding: 6px; color: var(--danger);"
                                            onclick="return confirm('Delete category?')">
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