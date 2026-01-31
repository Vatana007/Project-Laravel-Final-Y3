@extends('layout.app')

@section('title', 'Product Management')

@section('content')

    <div class="card animate-fade" style="border: none; box-shadow: var(--shadow-md);">

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);">

            <div style="position: relative; width: 300px;">
                <svg style="position: absolute; left: 12px; top: 10px; color: var(--text-muted);" width="20" height="20"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="tableSearch" class="form-control" placeholder="Search products..."
                    style="padding-left: 40px; margin-bottom: 0; border-radius: 50px;">
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary"
                style="padding: 0.6rem 1.2rem; font-weight: 600; border-radius: 50px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="table" style="vertical-align: middle;">
                <thead>
                    <tr
                        style="background: #f8fafc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);">
                        <th style="padding: 1rem; border-top-left-radius: 8px;">Product Name</th>
                        <th>Category</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: center;">Stock Status</th>
                        <th style="padding: 1rem; text-align: right; border-top-right-radius: 8px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @forelse($products as $product)
                        <tr class="hover-row" style="transition: background 0.2s; border-bottom: 1px solid var(--border);">

                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div
                                        style="width: 40px; height: 40px; background: #eff6ff; color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                        {{ substr($product->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-main);">{{ $product->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">
                                            {{ $product->barcode ?? 'No Barcode' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td style="color: var(--text-muted); font-size: 0.9rem;">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </td>

                            <td style="text-align: right; font-weight: 600; color: var(--text-main);">
                                ${{ number_format($product->sale_price, 2) }}
                            </td>

                            <td style="text-align: center;">
                                @if($product->qty <= 0)
                                    <span class="badge badge-danger">Out of Stock</span>
                                @elseif($product->qty <= 5)
                                    <span class="badge badge-warning">Low Stock ({{ $product->qty }})</span>
                                @else
                                    <span class="badge badge-success">In Stock ({{ $product->qty }})</span>
                                @endif
                            </td>

                            <td style="text-align: right; padding: 1rem;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn-icon"
                                        style="color: var(--secondary);" title="Edit">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn-icon"
                                            style="color: var(--danger); background: none; border: none; cursor: pointer;"
                                            onclick="return confirm('Are you sure you want to delete this product?')"
                                            title="Delete">
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
                            <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1"
                                    viewBox="0 0 24 24" style="margin-bottom: 1rem; color: #cbd5e1;">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p>No products found in the inventory.</p>
                                <a href="{{ route('products.create') }}"
                                    style="color: var(--primary); font-weight: 600; font-size: 0.9rem;">Create your first
                                    product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
        </div>
    </div>

    <style>
        /* Custom Badges for this page */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .hover-row:hover {
            background-color: #f8fafc;
        }

        .btn-icon {
            padding: 6px;
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
        // Simple Table Search Script
        document.getElementById('tableSearch').addEventListener('keyup', function () {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#productTableBody tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });
    </script>

@endsection