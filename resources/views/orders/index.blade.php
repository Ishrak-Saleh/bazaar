@extends('layouts.public')

@section('title', 'Your Orders - Bazaar')

@section('content')
<section class="page-wrap">
    <h1 class="page-title">Your Orders</h1>

    <div class="orders-stack">
        @forelse($orders as $order)
            <article class="order-card">
                <div class="order-head">
                    <div>
                        <div class="muted-label">Order Placed</div>
                        <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div>
                        <div class="muted-label">Total Amount</div>
                        <strong>৳{{ number_format($order->total, 0) }}</strong>
                    </div>
                    <div>
                        <div class="muted-label">Order ID</div>
                        <strong>{{ $order->order_number }}</strong>
                    </div>
                    <div class="status-pill">{{ strtoupper($order->status) }}</div>
                </div>

                <div class="order-items">
                    @foreach($order->items as $item)
                        <div class="order-item-row">
                            <div>
                                <strong>{{ $item->product_name }}</strong>
                                <div class="muted-label">{{ $item->product->category->name ?? 'Product' }}</div>
                            </div>
                            <div>Quantity: {{ $item->quantity }} kg · Price: ৳{{ number_format($item->unit_price, 0) }} / kg</div>
                        </div>
                    @endforeach
                </div>

                <div class="order-actions">
                    <a href="{{ route('orders.show', $order) }}" class="secondary-button">Track Order</a>
                </div>
            </article>
        @empty
            <div class="empty-state">You have no orders yet.</div>
        @endforelse
    </div>
</section>
@endsection
