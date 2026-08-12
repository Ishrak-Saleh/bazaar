@extends('layouts.dashboard')

@section('title', 'Manage Orders')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Manage Orders</h1>

        <p>
            Monitor customer orders, vendors, fulfillment, and payment details.
        </p>
    </div>

</div>


<div class="orders-stack">

    @forelse($orders as $order)

        <article class="vendor-order-card">

            {{-- =====================================================
                 ORDER HEADER
            ====================================================== --}}

            <div class="vendor-order-header">

                <div>

                    <span class="muted-label">
                        Order Number
                    </span>

                    <h2 class="vendor-order-number">
                        {{ $order->order_number }}
                    </h2>

                </div>


                <div class="vendor-order-meta">

                    <div>

                        <span class="muted-label">
                            Order Date
                        </span>

                        <strong>
                            {{ $order->created_at->timezone('Asia/Dhaka')->format('M d, Y · h:i A') }}
                        </strong>

                    </div>


                    <div>

                        <span class="muted-label">
                            Order Status
                        </span>

                        <span class="status-pill">
                            {{ ucfirst($order->status) }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 CUSTOMER + DELIVERY INFORMATION
            ====================================================== --}}

            <div class="vendor-order-info-grid">


                {{-- Customer Information --}}

                <section class="vendor-order-info-card">

                    <h3>
                        Customer Information
                    </h3>

                    <div class="vendor-order-info-list">

                        <div>

                            <span class="muted-label">
                                Full Name
                            </span>

                            <strong>
                                {{ $order->first_name }}
                                {{ $order->last_name }}
                            </strong>

                        </div>


                        <div>

                            <span class="muted-label">
                                Phone
                            </span>

                            <strong>
                                {{ $order->phone }}
                            </strong>

                        </div>


                        <div>

                            <span class="muted-label">
                                Email
                            </span>

                            <strong>
                                {{ $order->email }}
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- Delivery Information --}}

                <section class="vendor-order-info-card">

                    <h3>
                        Delivery Information
                    </h3>

                    <div class="vendor-order-info-list">

                        <div>

                            <span class="muted-label">
                                Delivery Address
                            </span>

                            <strong>
                                {{ $order->street_address }}
                            </strong>

                        </div>


                        <div>

                            <span class="muted-label">
                                City
                            </span>

                            <strong>
                                {{ $order->city }}
                            </strong>

                        </div>


                        <div>

                            <span class="muted-label">
                                Postal Code
                            </span>

                            <strong>
                                {{ $order->postal_code }}
                            </strong>

                        </div>

                    </div>

                </section>

            </div>


            {{-- =====================================================
                 PAYMENT
            ====================================================== --}}

            <section class="vendor-order-payment">

                <div>

                    <span class="muted-label">
                        Payment Method
                    </span>

                    <strong>
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                    </strong>

                </div>

            </section>


            {{-- =====================================================
                 ALL ORDER ITEMS
            ====================================================== --}}

            <section class="vendor-order-products">

                <div class="vendor-order-section-heading">

                    <div>

                        <span class="muted-label">
                            Marketplace Items
                        </span>

                        <h3>
                            Products in This Order
                        </h3>

                    </div>

                    <span class="badge">

                        {{ $order->items->count() }}

                        {{ $order->items->count() === 1 ? 'Item' : 'Items' }}

                    </span>

                </div>


                <div class="vendor-order-items">

                    @foreach($order->items as $item)

                        <div class="vendor-order-item">

                            {{-- Product + Vendor --}}

                            <div class="vendor-order-product">

                                @if($item->product && $item->product->image_path)

                                    <img
                                        src="{{ asset('storage/' . $item->product->image_path) }}"
                                        alt="{{ $item->product_name }}"
                                        class="vendor-order-product-image"
                                    >

                                @else

                                    <div class="vendor-order-product-placeholder">
                                        {{ strtoupper(substr($item->product_name, 0, 1)) }}
                                    </div>

                                @endif


                                <div>

                                    <strong class="vendor-order-product-name">
                                        {{ $item->product_name }}
                                    </strong>

                                    <span class="vendor-order-product-meta">
                                        Vendor:
                                        {{ $item->vendor->store_name ?? $item->vendor->fullName() }}
                                    </span>

                                </div>

                            </div>


                            {{-- Quantity --}}

                            <div class="vendor-order-item-detail">

                                <span class="muted-label">
                                    Quantity
                                </span>

                                <strong>
                                    {{ $item->quantity }} kg
                                </strong>

                            </div>


                            {{-- Unit Price --}}

                            <div class="vendor-order-item-detail">

                                <span class="muted-label">
                                    Unit Price
                                </span>

                                <strong>
                                    ৳{{ number_format($item->unit_price, 0) }}
                                </strong>

                            </div>


                            {{-- Subtotal --}}

                            <div class="vendor-order-item-detail">

                                <span class="muted-label">
                                    Subtotal
                                </span>

                                <strong>
                                    ৳{{ number_format($item->subtotal, 0) }}
                                </strong>

                            </div>


                            {{-- Vendor Status --}}

                            <div class="vendor-order-item-status">

                                <span class="muted-label">
                                    Vendor Status
                                </span>

                                <span class="status-pill">
                                    {{ ucfirst($item->vendor_status) }}
                                </span>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- Order subtotal --}}

                <div class="vendor-order-total">

                    <span>
                        Items Subtotal
                    </span>

                    <strong>
                        ৳{{ number_format($order->subtotal, 0) }}
                    </strong>

                </div>

            </section>


            {{-- =====================================================
                 ORDER NOTES
            ====================================================== --}}

            @if($order->notes)

                <section class="vendor-order-notes">

                    <span class="muted-label">
                        Order Notes
                    </span>

                    <p>
                        {{ $order->notes }}
                    </p>

                </section>

            @endif


            {{-- =====================================================
                 ORDER TOTALS
            ====================================================== --}}

            <section class="admin-order-totals">

                <div class="admin-order-total-row">
                    <span>Subtotal</span>
                    <strong>
                        ৳{{ number_format($order->subtotal, 0) }}
                    </strong>
                </div>


                <div class="admin-order-total-row">
                    <span>Delivery Fee</span>
                    <strong>
                        ৳{{ number_format($order->delivery_fee, 0) }}
                    </strong>
                </div>


                @if($order->discount > 0)

                    <div class="admin-order-total-row">
                        <span>Discount</span>
                        <strong>
                            -৳{{ number_format($order->discount, 0) }}
                        </strong>
                    </div>

                @endif


                <div class="admin-order-grand-total">

                    <span>
                        Customer Order Total
                    </span>

                    <strong>
                        ৳{{ number_format($order->total, 0) }}
                    </strong>

                </div>

            </section>


            {{-- =====================================================
                 ADMIN STATUS CONTROL
            ====================================================== --}}

            <div class="admin-order-status-control">

                <div>

                    <span class="muted-label">
                        Global Order Status
                    </span>

                    <p>
                        Update the overall status of this order.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('admin.orders.update', $order) }}"
                    class="admin-order-status-form"
                >

                    @csrf
                    @method('PATCH')

                    <select
                        name="status"
                        required
                    >

                        @foreach([
                            'pending',
                            'processing',
                            'shipped',
                            'delivered',
                            'cancelled'
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                @selected($order->status === $status)
                            >
                                {{ ucfirst($status) }}
                            </option>

                        @endforeach

                    </select>


                    <button
                        type="submit"
                        class="secondary-button"
                    >
                        Update Status
                    </button>

                </form>

            </div>

        </article>

    @empty

        <div class="empty-state">

            <h3>
                No orders yet
            </h3>

            <p>
                Customer orders will appear here.
            </p>

        </div>

    @endforelse

</div>

@endsection