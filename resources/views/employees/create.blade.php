@extends('layout.app')

@section('title', 'New Employee')

@section('content')

    <div class="animate-fade" style="max-width: 850px; margin: 2rem auto;">

        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('employees.index') }}" class="back-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="page-heading">Register New Employee</h1>
        </div>

        <div class="form-container">

            <div class="form-header">
                <h3>Employee Details</h3>
                <p>Enter the personal and professional information for the new staff member.</p>
            </div>

            <form action="{{ route('employees.store') }}" method="POST">
                @csrf

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
                            <input type="text" name="name" class="flat-input" placeholder="e.g. Jonathan Doe" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                            <span class="input-icon">@</span>
                            <input type="email" name="email" class="flat-input" placeholder="jonathan@nexus.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" name="phone" class="flat-input" placeholder="+1 234 567 890" required>
                        </div>
                    </div>

                    <div class="grid-divider span-2"></div>

                    <div class="form-group">
                        <label>Job Position</label>
                        <div class="select-wrapper">
                            <select name="position_id" class="flat-select" required>
                                <option value="" disabled selected>Select Role...</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="flat-input" value="{{ date('Y-m-d') }}" required>
                    </div>

                </div>

                <div class="form-footer">
                    <a href="{{ route('employees.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        Create Record
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <style>
        /* Structure */
        .page-heading {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
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

        /* Form Container */
        .form-container {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .form-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border);
            background: #fcfcfc;
        }

        .form-header h3 {
            margin: 0 0 5px 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .form-header p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Grid Layout */
        .form-grid {
            padding: 2rem;
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

        /* Inputs */
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
            padding: 10px 12px 10px 40px;
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

        /* Adjust padding for selects or inputs without icons */
        .flat-select,
        input[type="date"].flat-input {
            padding-left: 12px;
        }

        /* Footer */
        .form-footer {
            padding: 1.25rem 2rem;
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
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-save:hover {
            background: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        /* Mobile */
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