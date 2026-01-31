@extends('layout.app')

@section('title', 'Edit Employee')

@section('content')

    <div class="animate-fade" style="max-width: 850px; margin: 2rem auto;">

        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('employees.index') }}" class="back-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="page-heading">Edit Profile</h1>
                <span style="font-size: 0.85rem; color: var(--text-muted);">Editing:
                    <strong>{{ $employee->name }}</strong></span>
            </div>
        </div>

        <div class="form-container">

            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group span-2">
                        <label>Full Name</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <input type="text" name="name" class="flat-input" value="{{ $employee->name }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                            <span class="input-icon">@</span>
                            <input type="email" name="email" class="flat-input" value="{{ $employee->email }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-group">
                            <span class="input-icon">#</span>
                            <input type="text" name="phone" class="flat-input" value="{{ $employee->phone }}" required>
                        </div>
                    </div>

                    <div class="grid-divider span-2"></div>

                    <div class="form-group">
                        <label>Job Position</label>
                        <div class="select-wrapper">
                            <select name="position_id" class="flat-select" required>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}" {{ $employee->position_id == $pos->id ? 'selected' : '' }}>
                                        {{ $pos->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="flat-input" value="{{ $employee->start_date }}"
                            required>
                    </div>

                </div>

                <div class="form-footer">
                    <a href="{{ route('employees.index') }}" class="btn-cancel">Discard Changes</a>
                    <button type="submit" class="btn-save">
                        Update Profile
                    </button>
                </div>

            </form>
        </div>
    </div>

    <style>
        .page-heading {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            line-height: 1.2;
        }

        .back-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: 1px solid var(--border);
            color: var(--text-muted);
            transition: 0.2s;
        }

        .back-btn:hover {
            border-color: var(--text-main);
            color: var(--text-main);
        }

        .form-container {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .form-grid {
            padding: 2.5rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .span-2 {
            grid-column: span 2;
        }

        .grid-divider {
            height: 1px;
            background: var(--border);
            margin: 0.5rem 0;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            pointer-events: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .flat-input,
        .flat-select {
            width: 100%;
            padding: 12px 12px 12px 40px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .flat-input:focus,
        .flat-select:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .flat-select,
        input[type="date"].flat-input {
            padding-left: 12px;
        }

        .form-footer {
            padding: 1.25rem 2.5rem;
            background: #fcfcfc;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            align-items: center;
        }

        .btn-cancel {
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: 0.2s;
            font-size: 0.95rem;
        }

        .btn-cancel:hover {
            color: var(--text-main);
        }

        .btn-save {
            background: var(--text-main);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-save:hover {
            background: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        @media(max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .span-2 {
                grid-column: span 1;
            }
        }
    </style>

@endsection