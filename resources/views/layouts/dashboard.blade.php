<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bazaar Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body class="dashboard-shell">

    <div class="dashboard-layout">

        {{-- Mobile top bar --}}
        <header class="dashboard-mobile-header">

            <a
                href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'vendor.dashboard') }}"
                class="dashboard-logo"
            >
                <span class="dashboard-logo-brand">Bazaar.</span>
            </a>

            <button
                type="button"
                class="dashboard-menu-toggle"
                id="dashboardMenuToggle"
                aria-label="Open dashboard menu"
                aria-expanded="false"
            >
                ☰
            </button>

        </header>


        {{-- Sidebar --}}
        <aside class="dashboard-sidebar" id="dashboardSidebar">

            <div class="dashboard-sidebar-header">

                <a
                    href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'vendor.dashboard') }}"
                    class="dashboard-logo"
                >
                    <span class="dashboard-logo-full">
                        <span class="dashboard-logo-brand">Bazaar</span><span class="dashboard-logo-dot">.</span>{{ strtoupper(auth()->user()->role) }}
                    </span>

                    <span class="dashboard-logo-short">
                        B<span>.</span>
                    </span>
                </a>

                <button
                    type="button"
                    class="dashboard-collapse-toggle"
                    id="dashboardCollapseToggle"
                    aria-label="Collapse sidebar"
                    aria-expanded="true"
                >
                    ‹
                </button>

            </div>


            <nav class="sidebar-links">

                @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('admin.dashboard') }}"
                        data-label="Operations Hub"
                        data-icon="⌂"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">⌂</span>
                        <span class="sidebar-link-text">Operations Hub</span>
                    </a>

                    <a
                        href="{{ route('admin.vendors.index') }}"
                        data-label="Vendors"
                        data-icon="V"
                        class="{{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">V</span>
                        <span class="sidebar-link-text">Vendors</span>
                    </a>

                    <a
                        href="{{ route('admin.categories.index') }}"
                        data-label="Categories"
                        data-icon="C"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">C</span>
                        <span class="sidebar-link-text">Categories</span>
                    </a>

                    <a
                        href="{{ route('admin.products.index') }}"
                        data-label="Products"
                        data-icon="P"
                        class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">P</span>
                        <span class="sidebar-link-text">Products</span>
                    </a>

                    <a
                        href="{{ route('admin.freshness-requests.index') }}"
                        data-label="Freshness Requests"
                        data-icon="F"
                        class="{{ request()->routeIs('admin.freshness-requests.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">F</span>
                        <span class="sidebar-link-text">Freshness Requests</span>
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        data-label="Orders"
                        data-icon="O"
                        class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">O</span>
                        <span class="sidebar-link-text">Orders</span>
                    </a>

                    <a
                        href="{{ route('home') }}"
                        data-label="Public Catalog View"
                        data-icon="↗"
                    >
                        <span class="sidebar-link-icon">↗</span>
                        <span class="sidebar-link-text">Public Catalog View</span>
                    </a>

                @else

                    <a
                        href="{{ route('vendor.dashboard') }}"
                        data-label="Dashboard"
                        data-icon="⌂"
                        class="{{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">⌂</span>
                        <span class="sidebar-link-text">Dashboard</span>
                    </a>

                    <a
                        href="{{ route('vendor.products.index') }}"
                        data-label="My Products"
                        data-icon="P"
                        class="{{ request()->routeIs('vendor.products.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">P</span>
                        <span class="sidebar-link-text">My Products</span>
                    </a>

                    <a
                        href="{{ route('vendor.orders.index') }}"
                        data-label="My Orders"
                        data-icon="O"
                        class="{{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}"
                    >
                        <span class="sidebar-link-icon">O</span>
                        <span class="sidebar-link-text">My Orders</span>
                    </a>

                    <a
                        href="{{ route('home') }}"
                        data-label="Public Catalog View"
                        data-icon="↗"
                    >
                        <span class="sidebar-link-icon">↗</span>
                        <span class="sidebar-link-text">Public Catalog View</span>
                    </a>

                @endif

            </nav>


            <div class="sidebar-footer-note">

                <p>Bazaar Architecture v2.4</p>
                <p>Internal Ops Only</p>

            </div>

        </aside>


        {{-- Overlay used on mobile --}}
        <div
            class="dashboard-sidebar-overlay"
            id="dashboardSidebarOverlay"
        ></div>


        {{-- Main content --}}
        <main class="dashboard-main">

            @yield('content')

        </main>

    </div>

</body>
</html>
