@extends('layouts.dashboard')
@section('title', 'Manage Orders')

@section('content')
<div class="workspace-header">
    <div>
        <h1>Manage Orders</h1>
        <p>View every order and update its global status.</p>
    </div>
</div>

<div class="orders-stack">
    @foreach($orders as $order)
        <article class="order-card">
            <div class="order-head">
                <div><div class="muted-label">Order</div><strong>{{ $order->order_number }}</strong></div>
                <div><div class="muted-label">Customer</div><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></div>
                <div><div class="muted-label">Total</div><strong>৳{{ number_format($order->total, 0) }}</strong></div>
                <div class="status-pill">{{ $order->status }}</div>
            </div>

            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Item</th><th>Vendor</th><th>Qty</th><th>Vendor Status</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->vendor->fullName() }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->vendor_status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="action-row">
                @csrf
                @method('PATCH')
                <select name="status">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button type="submit" class="secondary-button">Update Status</button>
            </form>
        </article>
    @endforeach
</div>
@endsection
