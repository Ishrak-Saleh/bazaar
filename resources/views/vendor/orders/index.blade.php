@extends('layouts.dashboard')

@section('title', 'Vendor Orders')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Vendor Orders</h1>

        <p>
            Manage your products and track order fulfillment.
        </p>
    </div>

</div>


<div class="orders-stack">

    @forelse($items->groupBy('order_id') as $orderItems)

        @php
            $order = $orderItems->first()->order;

            $vendorSubtotal = $orderItems->sum(
                fn ($item) => $item->subtotal
            );
        @endphp


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
                            {{ $order->created_at->format('M d, Y · h:i A') }}
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
                 VENDOR PRODUCTS
            ====================================================== --}}

            <section class="vendor-order-products">

                <div class="vendor-order-section-heading">

                    <div>

                        <span class="muted-label">
                            Vendor Items
                        </span>

                        <h3>
                            Products in This Order
                        </h3>

                    </div>

                    <span class="badge">
                        {{ $orderItems->count() }}
                        {{ $orderItems->count() === 1 ? 'Item' : 'Items' }}
                    </span>

                </div>


                <div class="vendor-order-items">

                    @foreach($orderItems as $item)

                        <div class="vendor-order-item">

                            {{-- Product --}}

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
                                        {{ $item->quantity }} kg
                                        ×
                                        ৳{{ number_format($item->unit_price, 0) }}
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

                                <span class="status-pill">
                                    {{ ucfirst($item->vendor_status) }}
                                </span>

                                <form
                                    method="POST"
                                    action="{{ route('vendor.orders.update-item-status', $item) }}"
                                    class="vendor-status-form"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="vendor_status"
                                        required
                                    >

                                        <option
                                            value="processing"
                                            @selected($item->vendor_status === 'processing')
                                        >
                                            Processing
                                        </option>

                                        <option
                                            value="ready"
                                            @selected($item->vendor_status === 'ready')
                                        >
                                            Ready
                                        </option>

                                        <option
                                            value="shipped"
                                            @selected($item->vendor_status === 'shipped')
                                        >
                                            Shipped
                                        </option>

                                        <option
                                            value="cancelled"
                                            @selected($item->vendor_status === 'cancelled')
                                        >
                                            Cancelled
                                        </option>

                                    </select>

                                    <button
                                        type="submit"
                                        class="secondary-button"
                                    >
                                        Update
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- Vendor subtotal --}}

                <div class="vendor-order-total">

                    <span>
                        Your Items Subtotal
                    </span>

                    <strong>
                        ৳{{ number_format($vendorSubtotal, 0) }}
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
                 ORDER TOTAL
            ====================================================== --}}

            <div class="vendor-order-grand-total">

                <span>
                    Customer Order Total
                </span>

                <strong>
                    ৳{{ number_format($order->total, 0) }}
                </strong>

            </div>

        </article>

    @empty

        <div class="empty-state">

            <h3>
                No orders yet
            </h3>

            <p>
                Orders containing your products will appear here.
            </p>

        </div>

    @endforelse

</div>

@endsection