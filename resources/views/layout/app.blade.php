<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nexus POS')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        :root {
            --primary: #4f46e5;
            /* Indigo 600 */
            --primary-hover: #4338ca;
            --secondary: #64748b;
            /* Slate 500 */
            --success: #22c55e;
            /* Green 500 */
            --danger: #ef4444;
            /* Red 500 */
            --background: #f1f5f9;
            /* Slate 100 */
            --surface: #ffffff;
            --text-main: #0f172a;
            /* Slate 900 */
            --text-muted: #64748b;
            /* Slate 500 */
            --border: #e2e8f0;
            /* Slate 200 */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        /* Animation for Alerts */
        .animate-fade {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <nav class="sidebar">
        <div class="brand">
            <div class="logo-icon">POS</div>
            <span>Nexus</span>
        </div>

        <div class="nav-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                </path>
            </svg>
            Point of Sale
        </a>

        <div class="nav-label">Inventory</div>
        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Products
        </a>
        <a href="{{ route('categories.index') }}"
            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                </path>
            </svg>
            Categories
        </a>
        <a href="{{ route('stock.index') }}" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
            Adjustments
        </a>

        <div class="nav-label">People</div>
        <a href="{{ route('employees.index') }}"
            class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            Employees
        </a>

        <a href="{{ route('positions.index') }}"
            class="nav-link {{ request()->routeIs('positions.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            Work Positions
        </a>

        <a href="{{ route('customers.index') }}"
            class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            Customers
        </a>
        <a href="{{ route('suppliers.index') }}"
            class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Suppliers
        </a>

        <div class="nav-label">Reports</div>
        <a href="{{ route('reports.sales') }}"
            class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
            Sales Report
        </a>
    </nav>

    <main class="main-content">

        <div class="header-bar">
            <div>
                <h2 style="font-weight: 700; font-size: 1.5rem;">@yield('title', 'Dashboard')</h2>
                <p style="color: var(--text-muted);">Welcome, {{ auth()->user()->name ?? 'User' }}</p>
            </div>

            <div class="user-dropdown">
                <div class="dropdown-trigger">
                    <div
                        style="width: 32px; height: 32px; background: #e0e7ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span style="font-weight: 500;">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="color: var(--text-muted);">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <div class="dropdown-menu animate-fade">
                    <a href="#" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="animate-fade" style="
                    background: #fef2f2; 
                    border-left: 5px solid #ef4444; 
                    color: #991b1b; 
                    padding: 1rem 1.5rem; 
                    border-radius: 8px; 
                    margin-bottom: 2rem; 
                    display: flex; align-items: center; gap: 12px; 
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

                <svg style="color: #ef4444; min-width: 24px;" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>

                <div>
                    <strong style="font-size: 0.95rem; display: block;">Action Blocked</strong>
                    <span style="font-size: 0.9rem; opacity: 0.9;">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="animate-fade" style="
                    background: #f0fdf4; 
                    border-left: 5px solid #22c55e; 
                    color: #166534; 
                    padding: 1rem 1.5rem; 
                    border-radius: 8px; 
                    margin-bottom: 2rem; 
                    display: flex; align-items: center; gap: 12px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

                <svg style="color: #22c55e; min-width: 24px;" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>

                <div>
                    <strong style="font-size: 0.95rem; display: block;">Success</strong>
                    <span style="font-size: 0.9rem; opacity: 0.9;">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')

    </main>

</body>

</html>