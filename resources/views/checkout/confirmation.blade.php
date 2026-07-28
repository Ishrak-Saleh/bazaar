@extends('layouts.public')

@section('title', 'Order Confirmation - Bazaar')

@section('content')
<section class="page-wrap narrow">
    <div class="panel-card">
        <h1 class="page-title small">Order Confirmed</h1>
        <p>Your order <strong>{{ $order->order_number }}</strong> was placed successfully.</p>
        <a href="{{ route('orders.show', $order) }}" class="primary-button inline-block">View Order</a>
    </div>
</section>
@endsection
