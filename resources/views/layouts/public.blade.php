<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'Bazaar')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

    <script
        defer
        src="{{ asset('js/app.js') }}"
    ></script>
</head>

<body class="site-shell">

    <header class="site-header">

        <div class="nav-container">

            <a
                href="{{ route('home') }}"
                class="logo"
                aria-label="Bazaar Home"
            >
                Bazaar<span>.</span>
            </a>

            <nav class="top-actions">

                <a href="{{ route('home') }}">
                    Home
                </a>

                @auth

                    @if(auth()->user()->role === 'customer')

                        <a href="{{ route('orders.index') }}">
                            Orders
                        </a>

                        <a href="{{ route('profile.edit') }}">
                            Profile
                        </a>

                        <a
                            href="{{ route('cart.index') }}"
                            class="cart-link"
                        >
                            Cart
                        </a>

                    @elseif(auth()->user()->role === 'vendor')

                        <a href="{{ route('vendor.dashboard') }}">
                            Vendor
                        </a>

                        <a href="{{ route('profile.edit') }}">
                            Profile
                        </a>

                    @elseif(auth()->user()->role === 'admin')

                        <a href="{{ route('admin.dashboard') }}">
                            Admin
                        </a>

                    @endif

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="inline-form"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="link-button"
                        >
                            Logout
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                    <a href="{{ route('register') }}">
                        Register
                    </a>

                @endauth

            </nav>

        </div>

    </header>


    <main class="site-main">

        @yield('content')

    </main>


    <footer class="site-footer">

        <div class="footer-grid-wrapper">

            <div class="footer-brand-column">

                <a
                    href="{{ route('home') }}"
                    class="logo light"
                >
                    Bazaar<span>.</span>
                </a>

                <p>
                    Premium university engineering initiative
                    developing highly structured e-commerce
                    solutions natively from the ground up.
                </p>

            </div>


            <div>

                <h4 class="footer-column-headline">
                    Quick Links
                </h4>

                <ul class="footer-links-list">

                    <li>
                        <a href="{{ route('home') }}">
                            Product Catalog
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->isCustomer())

                            <li>
                                <a href="{{ route('orders.index') }}">
                                    Track Orders
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('profile.edit') }}">
                                    Account
                                </a>
                            </li>

                        @elseif(auth()->user()->isVendor())

                            <li>
                                <a href="{{ route('vendor.dashboard') }}">
                                    Vendor Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('profile.edit') }}">
                                    Account
                                </a>
                            </li>

                        @elseif(auth()->user()->isAdmin())

                            <li>
                                <a href="{{ route('admin.dashboard') }}">
                                    Admin Dashboard
                                </a>
                            </li>

                        @endif
                    @else

                        <li>
                            <a href="{{ route('login') }}">
                                Login
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('register') }}">
                                Create Account
                            </a>
                        </li>

                    @endauth

                </ul>

            </div>


            <div>

                <h4 class="footer-column-headline">
                    Categories
                </h4>

                <ul class="footer-links-list">

                    <li>
                        <a href="{{ route('home') }}?category=fruits">
                            Seasonal Fruits
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('home') }}?category=vegetables">
                            Native Vegetables
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('home') }}?category=organic-greens">
                            Fresh Field Greens
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('home') }}?category=seasonal-specialties">
                            Organic Specialties
                        </a>
                    </li>

                </ul>

            </div>


            <div>

                <h4 class="footer-column-headline">
                    Contact Hub
                </h4>

                <ul class="footer-links-list">

                    <li>
                        Sylhet, Bangladesh
                    </li>

                    <li>
                        support@bazaar.com
                    </li>

                    <li>
                        +880 1700-000000
                    </li>

                </ul>

            </div>

        </div>


        <div class="footer-bottom-bar">

            <p>
                &copy; 2026 Bazaar Project.
                Built with clean software standards. Mockup.
            </p>

        </div>

    </footer>


    @if(session('success'))

        <div
            class="toast active"
            role="status"
            aria-live="polite"
        >
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div
            class="toast active toast-error"
            role="alert"
            aria-live="assertive"
        >
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div
            class="toast active toast-error"
            role="alert"
            aria-live="assertive"
        >
            {{ $errors->first() }}
        </div>

    @endif

</body>
</html>