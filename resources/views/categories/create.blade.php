@extends('layout.app')

@section('title', 'New Category')

@section('content')

    <div style="max-width: 550px; margin: 0 auto; padding-top: 2rem;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Create Category</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Organize your inventory for faster checkout.</p>
        </div>

        <div class="card animate-fade"
            style="padding: 2.5rem; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label
                        style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Category
                        Name</label>
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 14px; top: 12px; color: #94a3b8;" width="20" height="20"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <input type="text" name="name" class="modern-input" placeholder="e.g. Beverages" required autofocus>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Description
                        (Optional)</label>
                    <textarea name="description" class="modern-input" rows="3"
                        placeholder="Brief details about this category..." style="padding-left: 1rem;"></textarea>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('categories.index') }}" class="btn"
                        style="flex: 1; background: white; border: 1px solid var(--border); color: var(--text-main); justify-content: center; font-weight: 600;">Cancel</a>
                    <button type="submit" class="btn btn-primary"
                        style="flex: 2; justify-content: center; font-weight: 600; padding: 0.8rem;">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <style>
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
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        textarea.modern-input {
            padding-left: 1rem;
        }

        /* Textarea doesn't need left icon padding */
    </style>

@endsection