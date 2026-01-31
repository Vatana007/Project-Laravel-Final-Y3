@extends('layout.app')

@section('title', 'Edit Position')

@section('content')

    <div class="animate-fade" style="max-width: 450px; margin: 4rem auto;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0;">Edit Role</h2>
            <a href="{{ route('positions.index') }}" class="btn-close">Cancel</a>
        </div>

        <div class="edit-card">

            <div class="card-accent"></div>
            <form action="{{ route('positions.update', $position->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 1.5rem;">
                    <label class="input-label">Role Title</label>
                    <input type="text" name="name" class="modern-input" value="{{ $position->name }}" required>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label class="input-label">Monthly Base Salary</label>
                    <div style="position: relative;">
                        <span
                            style="position: absolute; left: 12px; top: 11px; color: var(--text-muted); font-weight: 600;">$</span>
                        <input type="number" step="0.01" name="base_salary" class="modern-input" style="padding-left: 28px;"
                            value="{{ $position->base_salary }}" required>
                    </div>
                </div>

                <button type="submit" class="btn-save">Update Position</button>
            </form>
        </div>
    </div>

    <style>
        .edit-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .card-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary);
        }

        .input-label {
            display: block;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modern-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background: #fff;
            transition: 0.2s;
        }

        .modern-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-save {
            width: 100%;
            background: var(--text-main);
            color: white;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 1rem;
        }

        .btn-save:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        .btn-close {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 6px;
            transition: 0.2s;
        }

        .btn-close:hover {
            background: #f1f5f9;
            color: var(--text-main);
        }
    </style>

@endsection