@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Operations Dashboard</h1>

        <p>
            Monitor marketplace activity, vendors, products, and orders.
        </p>
    </div>

    <span class="status-pill">
        Systems Online
    </span>

</div>


{{-- =========================================================
     ADMIN STATS
========================================================= --}}

<div class="stats-grid">

    <div class="stat-card">
        <span>Gross Revenue</span>

        <strong>
            ৳{{ number_format($revenue, 0) }}
        </strong>
    </div>


    <div class="stat-card">
        <span>Total Orders</span>

        <strong>
            {{ $ordersCount }}
        </strong>
    </div>


    <div class="stat-card">
        <span>Active Products</span>

        <strong>
            {{ $productsCount }}
        </strong>
    </div>


    <div class="stat-card">
        <span>Vendors</span>

        <strong>
            {{ $vendorsCount }}
        </strong>
    </div>

</div>


{{-- =========================================================
     PENDING VENDORS + LATEST ORDERS
========================================================= --}}

<div class="two-col">


    {{-- Pending vendors --}}

    <section class="panel-card">

        <div class="panel-head">

            <div>
                <span class="muted-label">
                    Vendor Management
                </span>

                <h2>
                    Pending Vendor Applications
                </h2>
            </div>

            <a
                href="{{ route('admin.vendors.index') }}"
                class="secondary-button"
            >
                Open Vendors
            </a>

        </div>


        @if($pendingVendors->count() > 0)

            <div class="table-wrap">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Store</th>
                            <th>Status</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($pendingVendors as $vendor)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $vendor->fullName() }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $vendor->email }}
                                </td>

                                <td>
                                    {{ $vendor->store_name }}
                                </td>

                                <td>
                                    <span class="badge warning">
                                        {{ ucfirst($vendor->vendor_status) }}
                                    </span>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <h3>
                    No pending applications
                </h3>

                <p>
                    There are currently no vendors waiting for approval.
                </p>

                <a
                    href="{{ route('admin.vendors.index') }}"
                    class="secondary-button"
                >
                    Manage Vendors
                </a>

            </div>

        @endif

    </section>


    {{-- Latest orders --}}

    <section class="panel-card">

        <div class="panel-head">

            <div>
                <span class="muted-label">
                    Marketplace Activity
                </span>

                <h2>
                    Latest Orders
                </h2>
            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="secondary-button"
            >
                View All
            </a>

        </div>


        @if($latestOrders->count() > 0)

            <div class="table-wrap">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($latestOrders as $order)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $order->order_number }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $order->first_name }}
                                    {{ $order->last_name }}
                                </td>

                                <td>
                                    ৳{{ number_format($order->total, 0) }}
                                </td>

                                <td>

                                    <span class="badge">
                                        {{ ucfirst($order->status) }}
                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <h3>
                    No orders yet
                </h3>

                <p>
                    New customer orders will appear here.
                </p>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="secondary-button"
                >
                    Manage Orders
                </a>

            </div>

        @endif

    </section>

</div>


{{-- =========================================================
     ADMIN QUICK ACTIONS
========================================================= --}}

<section class="vendor-dashboard-card admin-actions-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">
                Administration
            </span>

            <h2>
                Keep Bazaar Operations Updated
            </h2>
        </div>

    </div>


    <p>
        Manage vendors, products, categories, orders, and freshness
        requests from the administration panel.
    </p>


    <div class="vendor-dashboard-actions">

        <a
            href="{{ route('admin.vendors.index') }}"
            class="primary-button"
        >
            Manage Vendors
        </a>

        <a
            href="{{ route('admin.products.index') }}"
            class="secondary-button"
        >
            Manage Products
        </a>

        <a
            href="{{ route('admin.categories.index') }}"
            class="secondary-button"
        >
            Manage Categories
        </a>

        <a
            href="{{ route('admin.orders.index') }}"
            class="secondary-button"
        >
            Manage Orders
        </a>

        <a
            href="{{ route('admin.freshness-requests.index') }}"
            class="secondary-button"
        >
            Freshness Requests
        </a>

    </div>

</section>

@endsection