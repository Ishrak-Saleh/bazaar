@extends('layouts.public')

@section('title', $product->name . ' - Bazaar')

@section('content')

<div class="detail-grid">

    <div class="detail-image-card">
        <img
            src="{{ $product->image_path ? asset('storage/'.$product->image_path) : asset('images/placeholder-product.svg') }}"
            alt="{{ $product->name }}"
        >
    </div>


    <div class="detail-info-card">

        <div class="meta-row">

            <span class="category-chip">
                {{ $product->category->name }}
            </span>

            <span class="stock-chip {{ $product->stock > 0 ? 'in' : 'out' }}">
                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}

                @if($product->stock > 0)
                    ({{ $product->stock }} available)
                @endif
            </span>

        </div>


        <h1>{{ $product->name }}</h1>


        <div class="price-row big">

            <span class="price">
                ৳{{ number_format($product->price, 0) }}
            </span>

            <span class="price-unit">
                / kg
            </span>

        </div>


        <p class="detail-copy">
            {{ $product->description }}
        </p>


        {{-- Freshness --}}
        @php
            $score = $product->freshness_score;

            $days = $product->arrival_date
                ->startOfDay()
                ->diffInDays(now()->startOfDay(), false);

            if ($days < 0) {
                $status = 'Arriving in ' . abs($days) . ' day' . (abs($days) > 1 ? 's' : '');
                $color = '#2563eb';
            } elseif ($days == 0) {
                $status = 'Harvested Today';
                $color = '#22c55e';
            } elseif ($days == 1) {
                $status = 'Harvested Yesterday';
                $color = '#84cc16';
            } else {
                $status = 'Harvested ' . $days . ' days ago';
                $color = '#f59e0b';
            }
        @endphp


        <div class="freshness-panel">

            <div class="freshness-header">
                <strong>Freshness Score</strong>
                <strong>{{ $score }}%</strong>
            </div>

            <div class="freshness-bar">

                <div
                    class="freshness-fill"
                    style="width: {{ $score }}%; background: {{ $color }};"
                ></div>

            </div>

            <div class="freshness-status">
                {{ $status }}
            </div>

        </div>


        {{-- Vendor --}}
        <div class="vendor-panel">

            <div class="vendor-label">
                Vendor
            </div>

            <div class="vendor-name">
                {{ $product->vendor->store_name ?? $product->vendor->fullName() }}
            </div>

        </div>


        {{-- Specifications --}}
        <div class="spec-grid">

            <div class="spec-card">
                <strong>Origin Zone</strong>
                <span>Bangladesh</span>
            </div>

            <div class="spec-card">
                <strong>Cultivation</strong>
                <span>Fresh Market</span>
            </div>

            <div class="spec-card">
                <strong>Stock Class</strong>
                <span>
                    {{ $product->stock > 10 ? 'Stable' : 'Low' }}
                </span>
            </div>

            <div class="spec-card">
                <strong>Weight</strong>
                <span>Per kg</span>
            </div>

        </div>


        {{-- Add to Cart --}}
        <form
            method="POST"
            action="{{ route('cart.add', $product) }}"
            class="detail-action-card"
        >
            @csrf

            <button
                type="submit"
                class="primary-button"
                {{ $product->stock <= 0 ? 'disabled' : '' }}
            >
                Add To Shopping Cart
            </button>

        </form>

    </div>

</div>


{{-- Reviews --}}

<div class="workspace-header">

    <div>

        <h2>Customer Reviews</h2>

        @if($product->reviews->count() > 0)

            <p>
                {{ number_format($product->reviews->avg('rating'), 1) }}
                / 5
                ·
                {{ $product->reviews->count() }}
                {{ $product->reviews->count() === 1 ? 'review' : 'reviews' }}
            </p>

        @else

            <p>
                No reviews yet.
            </p>

        @endif

    </div>

</div>


{{-- Review Form --}}
@auth

    @if(auth()->user()->isCustomer() && auth()->user()->hasVerifiedEmail())

        <div class="review-form-card">

            <h3>Write a Review</h3>

            <form
                method="POST"
                action="{{ route('products.reviews.store', $product) }}"
            >
                @csrf

                <div class="form-group">

                    <label for="rating">
                        Rating
                    </label>

                    <select
                        name="rating"
                        id="rating"
                        required
                    >
                        <option value="">
                            Select a rating
                        </option>

                        <option value="5">
                            5 - Excellent
                        </option>

                        <option value="4">
                            4 - Very Good
                        </option>

                        <option value="3">
                            3 - Good
                        </option>

                        <option value="2">
                            2 - Fair
                        </option>

                        <option value="1">
                            1 - Poor
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="review">
                        Your Review
                    </label>

                    <textarea
                        name="review"
                        id="review"
                        rows="4"
                        maxlength="1000"
                        placeholder="Share your experience with this product..."
                        required
                    >{{ old('review') }}</textarea>

                </div>


                <button
                    type="submit"
                    class="primary-button"
                >
                    Submit Review
                </button>

            </form>

        </div>

    @elseif(auth()->user()->isCustomer())

        <div class="review-message-card">

            <p>
                Please verify your email address before submitting a review.
            </p>

        </div>

    @endif

@else

    <div class="review-message-card">

        <p>
            Please log in as a customer to write a review.
        </p>

        <a
            href="{{ route('login') }}"
            class="secondary-button"
        >
            Log In
        </a>

    </div>

@endauth


{{-- Existing Reviews --}}
@if($product->reviews->count() > 0)

    <div class="reviews-list">

        @foreach($product->reviews->sortByDesc('created_at') as $review)

            <article class="review-card">

                <div class="review-header">

                    <div>

                        <strong>
                            {{ $review->user->fullName() }}
                        </strong>

                        <div class="review-rating">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                        </div>

                    </div>

                    <span class="review-date">
                        {{ $review->created_at->format('M d, Y') }}
                    </span>

                </div>


                <p>
                    {{ $review->review }}
                </p>

            </article>

        @endforeach

    </div>

@endif

@endsection