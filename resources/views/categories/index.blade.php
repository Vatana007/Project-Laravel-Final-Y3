@extends('layout.app')

@section('title', 'Categories')

@section('content')

    <div class="card animate-fade" style="border: none; box-shadow: var(--shadow-md);">

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);">

            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0;">Categories</h2>

                <div style="position: relative; width: 250px;">
                    <svg style="position: absolute; left: 12px; top: 10px; color: var(--text-muted);" width="18" height="18"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="categorySearch" class="form-control" placeholder="Search..."
                        style="padding-left: 38px; margin-bottom: 0; border-radius: 50px; font-size: 0.9rem;">
                </div>
            </div>

            <a href="{{ route('categories.create') }}" class="btn btn-primary"
                style="padding: 0.6rem 1.2rem; font-weight: 600; border-radius: 50px; font-size: 0.9rem;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                New Category
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="table" style="vertical-align: middle;">
                <thead>
                    <tr
                        style="background: #f8fafc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);">
                        <th style="padding: 1rem; border-top-left-radius: 8px;">Category Name</th>
                        <th>Description</th>
                        <th style="text-align: center;">Total Items</th>
                        <th style="padding: 1rem; text-align: right; border-top-right-radius: 8px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @forelse($categories as $category)
                        <tr class="hover-row" style="transition: background 0.2s; border-bottom: 1px solid var(--border);">

                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div
                                        style="width: 36px; height: 36px; background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%); color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; border: 1px solid rgba(255,255,255,0.5);">
                                        {{ substr($category->name, 0, 1) }}
                                    </div>
                                    <span style="font-weight: 600; color: var(--text-main);">{{ $category->name }}</span>
                                </div>
                            </td>

                            <td style="color: var(--text-muted); font-size: 0.9rem; max-width: 300px;">
                                {{ Str::limit($category->description ?? 'No description provided.', 50) }}
                            </td>

                            <td style="text-align: center;">
                                <span
                                    style="background: #f1f5f9; color: var(--text-main); font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; border: 1px solid var(--border);">
                                    {{ $category->products_count ?? $category->products->count() ?? 0 }} Products
                                </span>
                            </td>

                            <td style="text-align: right; padding: 1rem;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn-icon"
                                        style="color: var(--secondary);" title="Edit">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn-icon"
                                            style="color: var(--danger); background: none; border: none; cursor: pointer;"
                                            onclick="return confirm('Delete this category?')" title="Delete">
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
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                <p>No categories found.</p>
                                <a href="{{ route('categories.create') }}" style="color: var(--primary); font-weight: 600;">Add
                                    your first category</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .hover-row:hover {
            background-color: #f8fafc;
        }

        .btn-icon {
            padding: 8px;
            border-radius: 6px;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: #e2e8f0;
        }
    </style>

    <script>
        document.getElementById('categorySearch').addEventListener('keyup', function () {
            let value = this.value.toLowerCase();
            document.querySelectorAll('#categoryTableBody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>

@endsection