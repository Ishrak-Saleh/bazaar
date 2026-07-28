@extends('layouts.public')

@section('title', 'Order ' . $order->order_number . ' - Bazaar')

@section('content')
<section class="page-wrap narrow">
    <div class="panel-card">
        <h1 class="page-title small">Order {{ $order->order_number }}</h1>
        <div class="summary-row"><span>Status</span><span>{{ ucfirst($order->status) }}</span></div>
        <div class="summary-row"><span>Total</span><span>৳{{ number_format($order->total, 0) }}</span></div>
        <div class="summary-row"><span>Ship to</span><span>{{ $order->street_address }}, {{ $order->city }}</span></div>

        <hr class="separator">

        @foreach($order->items as $item)
            <div class="order-item-row">
                <div>
                    <strong>{{ $item->product_name }}</strong>
                    <div class="muted-label">Vendor: {{ $item->vendor->store_name ?? $item->vendor->name }}</div>
                </div>
                <div>Qty {{ $item->quantity }} · ৳{{ number_format($item->subtotal, 0) }}</div>
            </div>
        @endforeach
    </div>
</section>
@endsection
