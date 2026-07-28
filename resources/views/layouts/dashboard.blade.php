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
        <aside class="dashboard-sidebar">
            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'vendor.dashboard') }}" class="dashboard-logo">Bazaar<span>.</span>{{ strtoupper(auth()->user()->role) }}</a>

            <nav class="sidebar-links">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Operations Hub</a>
                    <a href="{{ route('admin.vendors.index') }}" class="{{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">Vendors</a>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Products</a>
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Orders</a>
                    <a href="{{ route('home') }}">Public Catalog View</a>
                @else
                    <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('vendor.products.index') }}" class="{{ request()->routeIs('vendor.products.*') ? 'active' : '' }}">My Products</a>
                    <a href="{{ route('vendor.orders.index') }}" class="{{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}">My Orders</a>
                    <a href="{{ route('home') }}">Public Catalog View</a>
                @endif
            </nav>

            <div class="sidebar-footer-note">
                <p>Bazaar Architecture v2.4</p>
                <p>Internal Ops Only</p>
            </div>
        </aside>

        <main class="dashboard-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
