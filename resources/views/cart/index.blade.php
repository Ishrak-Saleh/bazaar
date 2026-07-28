@extends('layouts.public')

@section('title', 'Your Cart - Bazaar')

@section('content')
<section class="page-wrap">
    <h1 class="page-title">Your Shopping Cart</h1>

    <div class="cart-grid">
        <div class="cart-items-list">
            @forelse($items as $item)
                @php($product = $item['product'])
                <article class="cart-item-card">
                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : asset('images/placeholder-product.svg') }}" alt="{{ $product->name }}" class="cart-thumb">
                    <div class="cart-details">
                        <div class="category-chip">{{ $product->category->name }}</div>
                        <h3>{{ $product->name }}</h3>
                        <div class="vendor-line">{{ $product->vendor->store_name ?? $product->vendor->name }}</div>
                        <div class="cart-bottom">
                            <form method="POST" action="{{ route('cart.update', $product) }}" class="qty-form">
                                @csrf
                                @method('PATCH')
                                <button name="qty" value="{{ max(1, $item['qty'] - 1) }}" class="qty-btn" type="submit">−</button>
                                <span class="qty-value">{{ $item['qty'] }}</span>
                                <button name="qty" value="{{ $item['qty'] + 1 }}" class="qty-btn" type="submit">+</button>
                            </form>
                            <div class="cart-price">৳{{ number_format($item['line_total'], 0) }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('cart.remove', $product) }}">
                        @csrf
                        @method('DELETE')
                        <button class="icon-button danger" type="submit">🗑</button>
                    </form>
                </article>
            @empty
                <div class="empty-state">Your cart is empty.</div>
            @endforelse
        </div>

        <aside class="summary-card">
            <h2>Order Summary</h2>
            <div class="summary-row"><span>Subtotal ({{ count($items) }} items)</span><span>৳{{ number_format($subtotal, 0) }}</span></div>
            <div class="summary-row"><span>Delivery</span><span>৳{{ number_format($deliveryFee, 0) }}</span></div>
            <div class="summary-row"><span>Promotional Discount</span><span>-৳{{ number_format($discount, 0) }}</span></div>
            <div class="summary-total"><span>Total</span><span>৳{{ number_format($total, 0) }}</span></div>
            <a href="{{ route('checkout.show') }}" class="primary-button full">Proceed to Checkout →</a>
            <a href="{{ route('home') }}" class="secondary-link">Continue Shopping</a>
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                @method('DELETE')
                <button class="secondary-button" type="submit">Clear Cart</button>
            </form>
        </aside>
    </div>
</section>
@endsection
