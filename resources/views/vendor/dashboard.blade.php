@extends('layouts.dashboard')
@section('title', 'Vendor Dashboard')

@section('content')
<div class="workspace-header">
    <div>
        <h1>Vendor Dashboard</h1>
        <p>Manage your own products and monitor your marketplace orders.</p>
    </div>
    <div class="status-pill soft success">Systems Online</div>
</div>

<div class="stats-grid">
    <div class="stat-card"><span>My Products</span><strong>{{ $productsCount }}</strong></div>
    <div class="stat-card"><span>My Orders</span><strong>{{ $ordersCount }}</strong></div>
    <div class="stat-card"><span>Earnings</span><strong>৳{{ number_format($earnings, 0) }}</strong></div>
    <div class="stat-card"><span>Vendor</span><strong>{{ auth()->user()->vendor_status }}</strong></div>
</div>

<div class="two-col">
    <section class="panel-card">
        <div class="panel-head">
            <h2>Recent Order Items</h2>
            <a href="{{ route('vendor.orders.index') }}" class="secondary-button">View All</a>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr><th>Order</th><th>Customer</th><th>Item</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($recentItems as $item)
                        <tr>
                            <td>{{ $item->order->order_number }}</td>
                            <td>{{ $item->order->first_name }} {{ $item->order->last_name }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td><span class="badge">{{ $item->vendor_status }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel-card">
        <h2>Vendor Notes</h2>
        <p>Use this panel to update product stock, review order items, and keep your own catalog aligned with the public storefront.</p>
        <a href="{{ route('vendor.products.index') }}" class="primary-button">Manage Products</a>
    </section>
</div>
@endsection
