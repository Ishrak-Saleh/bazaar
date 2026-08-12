@extends('layouts.dashboard')

@section('title', 'Vendor Dashboard')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Vendor Dashboard</h1>

        <p>
            Manage your own products and monitor your marketplace orders.
        </p>
    </div>

    <span class="status-pill">
        Systems Online
    </span>

</div>


{{-- =========================================================
     VENDOR STATS
========================================================= --}}

<div class="stats-grid">

    <div class="stat-card">
        <span>My Products</span>
        <strong>{{ $productsCount }}</strong>
    </div>


    <div class="stat-card">
        <span>My Orders</span>
        <strong>{{ $ordersCount }}</strong>
    </div>


    <div class="stat-card">
        <span>Earnings</span>
        <strong>
            ৳{{ number_format($earnings, 0) }}
        </strong>
    </div>


    <div class="stat-card">
        <span>Vendor Status</span>
        <strong>
            {{ ucfirst(auth()->user()->vendor_status) }}
        </strong>
    </div>

</div>


{{-- =========================================================
     RECENT ORDERS + VENDOR NOTES
========================================================= --}}

<div class="two-col">


    {{-- Recent orders --}}

    <section class="panel-card">

        <div class="panel-head">

            <div>
                <span class="muted-label">
                    Fulfillment
                </span>

                <h2>
                    Recent Order Items
                </h2>
            </div>

            <a
                href="{{ route('vendor.orders.index') }}"
                class="secondary-button"
            >
                View All
            </a>

        </div>


        @if($recentItems->count() > 0)

            <div class="table-wrap">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Status</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($recentItems as $item)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $item->order->order_number }}
                                    </strong>
                                </td>


                                <td>
                                    {{ $item->order->first_name }}
                                    {{ $item->order->last_name }}
                                </td>


                                <td>
                                    {{ $item->product_name }}
                                </td>


                                <td>

                                    <span class="badge">
                                        {{ ucfirst($item->vendor_status) }}
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
                    No recent orders
                </h3>

                <p>
                    Orders containing your products will appear here.
                </p>

                <a
                    href="{{ route('vendor.orders.index') }}"
                    class="secondary-button"
                >
                    View Orders
                </a>

            </div>

        @endif

    </section>


    {{-- Vendor notes --}}

    <section class="vendor-dashboard-card vendor-store-update-card">


            <div class="vendor-dashboard-card-header">

            <div>
                <span class="muted-label">
                    Vendor Notes
                </span>

                <h2>
                    Keep Your Store Updated
                </h2>
            </div>

        </div>

        <p>
            Keep your product stock, pricing, freshness information,
            and order fulfillment status aligned with the public
            Bazaar storefront.
        </p>

        <div class="vendor-dashboard-actions">

            <a
                href="{{ route('vendor.products.index') }}"
                class="primary-button"
            >
                Manage Products
            </a>

            <a
                href="{{ route('vendor.orders.index') }}"
                class="secondary-button"
            >
                Manage Orders
            </a>

            <a
                href="{{ route('home') }}"
                class="secondary-button"
            >
                View Storefront
            </a>

        </div>


    </section>

</div>




@endsection