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
    @foreach($items as $item)
        <article class="order-card">
            <div class="order-head">
                <div><div class="muted-label">Order</div><strong>{{ $item->order->order_number }}</strong></div>
                <div><div class="muted-label">Customer</div><strong>{{ $item->order->first_name }} {{ $item->order->last_name }}</strong></div>
                <div><div class="muted-label">Item</div><strong>{{ $item->product_name }}</strong></div>
                <div class="status-pill">{{ $item->vendor_status }}</div>
            </div>
            <form method="POST" action="{{ route('vendor.orders.update-item-status', $item) }}" class="action-row">
                @csrf
                @method('PATCH')
                <select name="vendor_status">
                    <option value="pending" @selected($item->vendor_status === 'pending')>pending</option>
                    <option value="processing" @selected($item->vendor_status === 'processing')>processing</option>
                    <option value="ready" @selected($item->vendor_status === 'ready')>ready</option>
                    <option value="shipped" @selected($item->vendor_status === 'shipped')>shipped</option>
                </select>
                <button type="submit" class="secondary-button">Update</button>
            </form>
        </article>
    @endforeach
</div>
@endsection
