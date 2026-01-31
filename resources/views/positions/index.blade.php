@extends('layout.app')

@section('title', 'Work Positions')

@section('content')

    <div class="animate-fade" style="max-width: 1000px; margin: 0 auto;">

        <div style="margin-bottom: 2rem;">
            <h1 class="page-title">Work Positions</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Manage job roles and salary structures.</p>
        </div>

        <div class="tile-grid">

            <button onclick="openModal('addPositionModal')" class="add-tile">
                <div class="add-icon-circle">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span style="font-weight: 600; font-size: 1rem;">Create New Role</span>
                <span style="font-size: 0.8rem; opacity: 0.7;">Click to define position</span>
            </button>

            @foreach($positions as $pos)
                <div class="pos-tile">

                    <div class="tile-header">
                        <span class="salary-tag">${{ number_format($pos->base_salary, 0) }}</span>

                        <div class="tile-actions">
                            <a href="{{ route('positions.edit', $pos->id) }}" class="icon-btn edit" title="Edit">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </a>
                            <form action="{{ route('positions.destroy', $pos->id) }}" method="POST"
                                onsubmit="return confirm('Delete this role?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn delete" title="Delete">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="tile-body">
                        <div class="role-initials">{{ substr($pos->name, 0, 2) }}</div>
                        <h3 class="role-name">{{ $pos->name }}</h3>
                        <div class="role-meta">Base Salary / Month</div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

    <div id="addPositionModal" class="modal-backdrop" style="display: none;">
        <div class="modal-box animate-fade">
            <div class="modal-header">
                <h3>New Position</h3>
                <button onclick="closeModal('addPositionModal')" class="close-x">&times;</button>
            </div>

            <div style="padding: 1.5rem;">
                <form action="{{ route('positions.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1.25rem;">
                        <label
                            style="display: block; font-weight: 700; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Role
                            Title</label>
                        <input type="text" name="name" class="modern-input" placeholder="e.g. Senior Manager" required>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label
                            style="display: block; font-weight: 700; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Base
                            Salary</label>
                        <div style="position: relative;">
                            <span
                                style="position: absolute; left: 12px; top: 11px; color: var(--text-muted); font-weight: 600;">$</span>
                            <input type="number" step="0.01" name="base_salary" class="modern-input" placeholder="0.00"
                                style="padding-left: 28px;" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-block">Create Position</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Grid System */
        .tile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        /* 1. Add Tile Styling */
        .add-tile {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 200px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-muted);
        }

        .add-tile:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #f0fdfa;
            /* Subtle tint */
        }

        .add-icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: white;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            transition: 0.2s;
        }

        .add-tile:hover .add-icon-circle {
            border-color: var(--primary);
            color: var(--primary);
            transform: scale(1.1);
        }

        /* 2. Position Tile Styling */
        .pos-tile {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 200px;
            transition: 0.2s;
            position: relative;
            overflow: hidden;
            border-top: 4px solid var(--primary);
            /* Accent Top Border */
        }

        .pos-tile:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        /* Tile Internals */
        .tile-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .salary-tag {
            background: #ecfdf5;
            color: #047857;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .tile-actions {
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: 0.2s;
        }

        .pos-tile:hover .tile-actions {
            opacity: 1;
        }

        /* Show actions on hover */

        .icon-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            background: #f1f5f9;
            color: var(--text-muted);
            transition: 0.2s;
        }

        .icon-btn.edit:hover {
            background: var(--primary);
            color: white;
        }

        .icon-btn.delete:hover {
            background: var(--danger);
            color: white;
        }

        .tile-body {
            text-align: center;
            margin-top: auto;
            padding-bottom: 10px;
        }

        .role-initials {
            width: 42px;
            height: 42px;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 12px;
            font-weight: 800;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
            text-transform: uppercase;
        }

        .role-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 4px 0;
        }

        .role-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Modal Styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-box {
            background: white;
            width: 100%;
            max-width: 380px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .modal-header {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1rem;
            color: var(--text-main);
        }

        .close-x {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .modern-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            background: #fff;
            transition: 0.2s;
        }

        .modern-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-block {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-block:hover {
            background: var(--primary-hover);
        }
    </style>

    <script>
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        window.onclick = function (event) {
            let modal = document.getElementById('addPositionModal');
            if (event.target == modal) modal.style.display = "none";
        }
    </script>

@endsection