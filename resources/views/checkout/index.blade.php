@extends('layouts.public')

@section('title', 'Checkout - Bazaar')

@section('content')

<section class="page-wrap">

    <div class="checkout-grid">

        {{-- Checkout Form --}}
        <form method="POST" action="{{ route('checkout.store') }}" class="panel-card checkout-form">
            @csrf

            <h1 class="page-title small">Checkout</h1>

            <p class="detail-copy">
                Enter your delivery details and confirm your order.
            </p>

            <hr class="separator">

            <h2 class="section-title">Delivery Details</h2>

            <div class="form-grid">

                <label>
                    First Name
                    <input
                        type="text"
                        name="first_name"
                        value="{{ old('first_name', auth()->user()->first_name) }}"
                        required
                    >
                </label>

                <label>
                    Last Name
                    <input
                        type="text"
                        name="last_name"
                        value="{{ old('last_name', auth()->user()->last_name) }}"
                        required
                    >
                </label>

                <label>
                    Email Address
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                    >
                </label>

                <label>
                    Phone Number
                    <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone', auth()->user()->phone) }}"
                        required
                    >
                </label>

                <label class="full">
                    Street Address
                    <input
                        type="text"
                        name="street_address"
                        value="{{ old('street_address', auth()->user()->address) }}"
                        required
                    >
                </label>

                <label>
                    City
                    <input
                        type="text"
                        name="city"
                        value="{{ old('city', auth()->user()->city ?? 'Sylhet') }}"
                        required
                    >
                </label>

                <label>
                    Postal Code
                    <input
                        type="text"
                        name="postal_code"
                        value="{{ old('postal_code', auth()->user()->postal_code ?? '3100') }}"
                        required
                    >
                </label>

            </div>

            <hr class="separator">

            {{-- Payment --}}
            <h2 class="section-title">Payment Method</h2>

            <div class="payment-options">

                <label class="payment-option payment-option-selected">

                    <input
                        type="radio"
                        name="payment_method"
                        value="cod"
                        checked
                        required
                    >

                    <span>
                        <strong>Cash on Delivery</strong>
                        <small>
                            Pay in cash when your order is delivered.
                        </small>
                    </span>

                </label>

            </div>

            <label class="notes-field">
                Order Notes

                <textarea
                    name="notes"
                    rows="4"
                    maxlength="1000"
                    placeholder="Optional notes for the rider or vendor"
                >{{ old('notes') }}</textarea>

            </label>

            <button type="submit" class="primary-button full">
                Place Order
            </button>

        </form>


        {{-- Order Summary --}}
        <aside class="summary-card checkout-summary">

            <h2>Order Summary</h2>

            <div class="summary-items">

                @foreach($items as $item)

                    <div class="summary-item">

                        <div>
                            <strong>
                                {{ $item['product']->name }}
                            </strong>

                            <small>
                                {{ $item['qty'] }} kg ×
                                ৳{{ number_format($item['product']->price, 0) }}
                            </small>
                        </div>

                        <span>
                            ৳{{ number_format($item['line_total'], 0) }}
                        </span>

                    </div>

                @endforeach

            </div>

            <hr class="separator">

            <div class="summary-row">
                <span>Subtotal</span>
                <span>
                    ৳{{ number_format($subtotal, 0) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Delivery</span>
                <span>
                    ৳{{ number_format($deliveryFee, 0) }}
                </span>
            </div>

            @if($discount > 0)

                <div class="summary-row">
                    <span>Discount</span>
                    <span>
                        -৳{{ number_format($discount, 0) }}
                    </span>
                </div>

            @endif

            <div class="summary-total">
                <span>Total</span>
                <span>
                    ৳{{ number_format($total, 0) }}
                </span>
            </div>

        </aside>

    </div>

</section>

@endsection