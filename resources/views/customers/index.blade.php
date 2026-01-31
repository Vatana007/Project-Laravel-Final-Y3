@extends('layout.app')

@section('title', 'Member Directory')

@section('content')

    <div class="animate-fade" style="max-width: 1200px; margin: 0 auto;">

        <div class="page-header">
            <div>
                <h1 class="page-title">Members</h1>
                <p class="page-subtitle">Manage your customer base and loyalty program.</p>
            </div>

            <div class="header-actions">
                <div class="search-box">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Search members..." class="search-input">
                </div>
                <a href="{{ route('customers.create') }}" class="btn-add">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Member
                </a>
            </div>
        </div>

        <div class="members-grid">

            @forelse($customers as $member)
                <div class="member-card">

                    <div class="card-top">
                        <div class="member-avatar">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                        <div class="card-menu">
                            <a href="{{ route('customers.edit', $member->id) }}" class="menu-btn edit" title="Edit">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </a>
                            <form action="{{ route('customers.destroy', $member->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Remove this member?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="menu-btn delete" title="Delete">
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

                    <div class="card-info">
                        <h3 class="member-name">{{ $member->name }}</h3>
                        <div class="info-row">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span>{{ $member->phone }}</span>
                        </div>
                        <div class="info-row">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="email-text">{{ $member->email ?? 'No email' }}</span>
                        </div>
                        <div class="info-row">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $member->address ?? 'No address' }}</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3>No Members Found</h3>
                    <p>Start building your customer base today.</p>
                    <a href="{{ route('customers.create') }}" class="btn-link">Add First Member</a>
                </div>
            @endforelse

        </div>
    </div>

    <style>
        /* Layout */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            line-height: 1.2;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 4px 0 0 0;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Search Box */
        .search-box {
            position: relative;
        }

        .search-box svg {
            position: absolute;
            left: 12px;
            top: 10px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .search-input {
            padding: 10px 12px 10px 40px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            width: 220px;
            transition: 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary);
            outline: none;
            width: 260px;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-add {
            background: var(--text-main);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-add:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        /* Grid */
        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Member Card */
        .member-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: 0.2s;
            position: relative;
            overflow: hidden;
        }

        .member-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .member-avatar {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card-menu {
            display: flex;
            gap: 6px;
        }

        .menu-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
        }

        .menu-btn.edit:hover {
            background: #eff6ff;
            color: var(--primary);
            border-color: #dbeafe;
        }

        .menu-btn.delete:hover {
            background: #fef2f2;
            color: var(--danger);
            border-color: #fee2e2;
        }

        .member-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 1rem 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .info-row svg {
            color: #94a3b8;
            min-width: 14px;
        }

        .email-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem;
            background: white;
            border: 1px dashed var(--border);
            border-radius: 16px;
        }

        .empty-icon {
            color: var(--primary);
            opacity: 0.5;
            margin-bottom: 1rem;
        }

        .btn-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            margin-top: 1rem;
            display: inline-block;
        }

        .btn-link:hover {
            text-decoration: underline;
        }
    </style>

@endsection