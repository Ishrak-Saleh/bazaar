@extends('layouts.dashboard')

@section('title', 'Vendor Orders')

@section('content')

<div class="workspace-header">
    <div>
        <h1>Vendor Orders</h1>
        <p>Update item fulfillment status for your own products.</p>
    </div>
</div>

<div class="orders-stack">

    @foreach($items->groupBy('order_id') as $orderItems)

        @php
            $order = $orderItems->first()->order;
        @endphp

        <article class="order-card">

            <div class="order-head">

                <div>
                    <div class="muted-label">Order</div>
                    <strong>{{ $order->order_number }}</strong>
                </div>

                <div>
                    <div class="muted-label">Customer</div>
                    <strong>
                        {{ $order->first_name }}
                        {{ $order->last_name }}
                    </strong>
                </div>

            </div>

            <div class="order-items">

                @foreach($orderItems as $item)

                    <div class="order-item-row">

                        <div>
                            <div class="muted-label">Item</div>
                            <strong>{{ $item->product_name }}</strong>

                            <div class="muted-label">
                                Quantity: {{ $item->quantity }}
                            </div>
                        </div>

                        <div class="status-pill">
                            {{ ucfirst($item->vendor_status) }}
                        </div>

                    </div>

                    <form
                        method="POST"
                        action="{{ route('vendor.orders.update-item-status', $item) }}"
                        class="action-row">

                        @csrf
                        @method('PATCH')

                        <select name="vendor_status" required>

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

                        <button type="submit" class="secondary-button">
                            Update
                        </button>

                    </form>

                @endforeach

            </div>

        </article>

    @endforeach

</div>

@endsection