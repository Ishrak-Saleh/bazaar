@extends('layouts.public')

@section('title', 'Checkout - Bazaar')

@section('content')
<section class="page-wrap">
    <div class="checkout-grid">
        <form method="POST" action="{{ route('checkout.store') }}" class="panel-card">
            @csrf
            <h1 class="page-title small">1. Delivery Logistics</h1>
            <div class="form-grid">
                <label>First Name <input name="first_name" value="{{ auth()->user()->first_name }}" required></label>
                <label>Last Name <input name="last_name" value="{{ auth()->user()->last_name }}" required></label>
                <label>Email Address <input type="email" name="email" value="{{ auth()->user()->email }}" required></label>
                <label>Phone Number <input name="phone" value="{{ auth()->user()->phone }}" required></label>
                <label class="full">Street Address <input name="street_address" value="{{ auth()->user()->address }}" required></label>
                <label>City <input name="city" value="{{ auth()->user()->city ?? 'Sylhet' }}" required></label>
                <label>Postal Code <input name="postal_code" value="{{ auth()->user()->postal_code ?? '3100' }}" required></label>
            </div>

            <h2 class="section-title">2. Settlement Channel</h2>
            <div class="payment-options">
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="cod" checked>
                    <span>
                        <strong>Cash On Delivery (COD)</strong>
                        <small>Settle payment using physical currency upon delivery.</small>
                    </span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="bkash">
                    <span>
                        <strong>bKash / Mobile Wallet Gateway</strong>
                        <small>Instant redirection to secure mobile wallet authorization.</small>
                    </span>
                </label>
            </div>

            <label class="notes-field">Order Notes
                <textarea name="notes" rows="4" placeholder="Optional notes for the rider or vendor"></textarea>
            </label>

            <button type="submit" class="primary-button">Confirm and Authorize Order</button>
        </form>

        <aside class="summary-card checkout-summary">
            <h2>Order Summary</h2>
            @foreach($items as $item)
                <div class="summary-item">
                    <strong>{{ $item['product']->name }}</strong>
                    <small>Quantity: {{ $item['qty'] }} kg</small>
                    <span>৳{{ number_format($item['line_total'], 0) }}</span>
                </div>
            @endforeach
            <div class="summary-row"><span>Subtotal Items</span><span>৳{{ number_format($subtotal, 0) }}</span></div>
            <div class="summary-row"><span>Standard Logistics Route</span><span>৳{{ number_format($deliveryFee, 0) }}</span></div>
            <div class="summary-total"><span>Total Payable</span><span>৳{{ number_format($total, 0) }}</span></div>
        </aside>
    </div>
</section>
@endsection
