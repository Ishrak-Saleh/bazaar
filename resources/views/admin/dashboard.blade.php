@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')

@section('content')
<div class="workspace-header">
    <div>
        <h1>Operations Dashboard</h1>
        <p>Real-time farm-to-table logistics fulfillment panel.</p>
    </div>
    <div class="status-pill soft success">Systems Online</div>
</div>

<div class="stats-grid">
    <div class="stat-card"><span>Gross Revenue Today</span><strong>৳{{ number_format($revenue, 0) }}</strong></div>
    <div class="stat-card"><span>Fulfillment Queue</span><strong>{{ $ordersCount }}</strong></div>
    <div class="stat-card"><span>Active Products</span><strong>{{ $productsCount }}</strong></div>
    <div class="stat-card"><span>Orchard Partners</span><strong>{{ $vendorsCount }}</strong></div>
</div>

<div class="two-col">
    <section class="panel-card">
        <div class="panel-head">
            <h2>Pending Vendor Applications</h2>
            <a href="{{ route('admin.vendors.index') }}" class="secondary-button">Open Vendors</a>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Name</th><th>Email</th><th>Store</th><th>State</th></tr></thead>
                <tbody>
                    @forelse($pendingVendors as $vendor)
                        <tr>
                            <td>{{ $vendor->fullName() }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->store_name }}</td>
                            <td><span class="badge warning">{{ $vendor->vendor_status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No pending vendors.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel-card">
        <h2>Latest Orders</h2>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($latestOrders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>৳{{ number_format($order->total, 0) }}</td>
                            <td><span class="badge">{{ $order->status }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
