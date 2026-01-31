@extends('layout.app')

@section('title', 'Edit Adjustment')

@section('content')

    <div style="max-width: 600px; margin: 0 auto; padding-top: 2rem;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Edit Adjustment</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Editing for product: <strong>{{ $transaction->product->name }}</strong>
            </p>
        </div>

        <div class="card animate-fade"
            style="padding: 2.5rem; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">

            <form action="{{ route('stock.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div
                    style="background: #fff7ed; border: 1px solid #ffedd5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; gap: 10px; align-items: start;">
                    <svg style="color: #c2410c; min-width: 20px;" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <p style="color: #9a3412; font-size: 0.85rem; margin: 0; line-height: 1.4;">
                        <strong>Caution:</strong> Changing this will automatically reverse the previous stock change and
                        apply the new one.
                    </p>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.8rem; text-align: center;">Adjustment
                        Type</label>

                    <div
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; background: #f1f5f9; padding: 5px; border-radius: 12px;">
                        <label class="type-option">
                            <input type="radio" name="type" value="in" {{ $transaction->type == 'in' ? 'checked' : '' }}
                                onchange="toggleTheme('in')">
                            <div class="option-box" id="box-in">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Add Stock</span>
                            </div>
                        </label>

                        <label class="type-option">
                            <input type="radio" name="type" value="out" {{ $transaction->type == 'out' ? 'checked' : '' }}
                                onchange="toggleTheme('out')">
                            <div class="option-box" id="box-out">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path d="M20 12H4"></path>
                                </svg>
                                <span>Remove Stock</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div>
                        <label
                            style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem;">Quantity</label>
                        <input type="number" name="qty" class="modern-input" placeholder="0" required min="1"
                            style="font-weight: 700; text-align: center;">
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem;">Reason
                            / Note</label>
                        <input type="text" name="note" id="noteField" class="modern-input" value="{{ $transaction->note }}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('stock.index') }}" class="btn"
                        style="flex: 1; background: white; border: 1px solid var(--border); color: var(--text-main); justify-content: center; font-weight: 600;">Cancel</a>
                    <button type="submit" id="submitBtn" class="btn btn-primary"
                        style="flex: 2; justify-content: center; font-weight: 600; padding: 0.8rem;">Update
                        Adjustment</button>
                </div>

            </form>
        </div>
    </div>

    <style>
        /* Reuse Modern Input Styles */
        .modern-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            background-color: #f8fafc;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .modern-input:focus {
            background-color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .type-option input {
            display: none;
        }

        .type-option {
            cursor: pointer;
        }

        .option-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            color: var(--text-muted);
            transition: 0.2s;
        }
    </style>

    <script>
        function toggleTheme(type) {
            const btn = document.getElementById('submitBtn');
            const boxIn = document.getElementById('box-in');
            const boxOut = document.getElementById('box-out');

            // Reset
            boxIn.style.color = 'var(--text-muted)'; boxIn.style.background = 'transparent'; boxIn.style.boxShadow = 'none';
            boxOut.style.color = 'var(--text-muted)'; boxOut.style.background = 'transparent'; boxOut.style.boxShadow = 'none';

            if (type === 'in') {
                btn.style.background = '#10b981'; btn.style.borderColor = '#10b981';
                boxIn.style.color = '#10b981'; boxIn.style.background = 'white'; boxIn.style.boxShadow = '0 2px 5px rgba(0,0,0,0.05)';
            } else {
                btn.style.background = '#ef4444'; btn.style.borderColor = '#ef4444';
                boxOut.style.color = '#ef4444'; boxOut.style.background = 'white'; boxOut.style.boxShadow = '0 2px 5px rgba(0,0,0,0.05)';
            }
        }

        // Run on load based on current value
        window.addEventListener('DOMContentLoaded', () => {
            toggleTheme("{{ $transaction->type }}");
        });
    </script>

@endsection