@extends('layouts.public')

@section('title', $product->name . ' - Bazaar')

@section('content')

<section class="detail-shell">

    {{-- Breadcrumbs --}}
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span>/</span>
        <span>{{ $product->category->name }}</span>
        <span>/</span>
        <strong>{{ $product->name }}</strong>
    </div>


    {{-- Product Details --}}
    <div class="detail-grid">

        {{-- Product Image --}}
        <div class="detail-image-card">

            <div class="detail-image-wrap">
                <img
                    src="{{ $product->image_path
                        ? asset('storage/' . $product->image_path)
                        : asset('images/placeholder-product.svg') }}"
                    alt="{{ $product->name }}"
                >
            </div>

        </div>


        {{-- Product Information --}}
        <div class="detail-info-card">

            {{-- Category + Stock --}}
            <div class="meta-row">

                <span class="category-chip">
                    {{ $product->category->name }}
                </span>

                <span class="stock-chip {{ $product->stock > 0 ? 'in' : 'out' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}

                    @if($product->stock > 0)
                        · {{ $product->stock }} available
                    @endif
                </span>

            </div>


            {{-- Product Name --}}
            <h1>
                {{ $product->name }}
            </h1>


            {{-- Price --}}
            <div class="price-row big">

                <span class="price">
                    ৳{{ number_format($product->price, 0) }}
                </span>

                <span class="price-unit">
                    / kg
                </span>

            </div>


            {{-- Description --}}
            <div class="detail-description">

                <span class="muted-label">
                    Product Description
                </span>

                <p class="detail-copy">
                    {{ $product->description }}
                </p>

            </div>


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

                    <div>
                        <span class="muted-label">
                            Product Freshness
                        </span>

                        <strong>
                            {{ $status }}
                        </strong>
                    </div>

                    <strong class="freshness-score">
                        {{ $score }}%
                    </strong>

                </div>


                <div class="freshness-bar">

                    <div
                        class="freshness-fill"
                        style="
                            width: {{ $score }}%;
                            background: {{ $color }};
                        "
                    ></div>

                </div>

            </div>


            {{-- Vendor --}}
            <div class="vendor-panel">

                <div class="vendor-label">
                    Sold By
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
                    class="primary-button full"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}
                >
                    {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>

            </form>

        </div>

    </div>


    {{-- Reviews --}}
    <section class="reviews-section">

        <div class="reviews-header-card">

            <div>

                <span class="muted-label">
                    Customer Feedback
                </span>

                <h2>
                    Customer Reviews
                </h2>

                @if($product->reviews->count() > 0)

                    <p class="reviews-summary">

                        <strong>
                            {{ number_format($product->reviews->avg('rating'), 1) }}
                            / 5
                        </strong>

                        <span>·</span>

                        <span>
                            {{ $product->reviews->count() }}
                            {{ $product->reviews->count() === 1 ? 'review' : 'reviews' }}
                        </span>

                    </p>

                @else

                    <p class="reviews-summary">
                        No reviews yet. Be the first to review this product.
                    </p>

                @endif

            </div>

        </div>


        {{-- Review Form --}}
        @auth

            @if(auth()->user()->isCustomer() && auth()->user()->hasVerifiedEmail())

                <div class="review-form-card">

                    <div class="review-form-heading">

                        <span class="muted-label">
                            Your Experience
                        </span>

                        <h3>
                            Write a Review
                        </h3>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('products.reviews.store', $product) }}"
                        class="review-form"
                    >
                        @csrf


                        <div class="form-grid">

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

                                    <option
                                        value="5"
                                        @selected(old('rating') == 5)
                                    >
                                        5 - Excellent
                                    </option>

                                    <option
                                        value="4"
                                        @selected(old('rating') == 4)
                                    >
                                        4 - Very Good
                                    </option>

                                    <option
                                        value="3"
                                        @selected(old('rating') == 3)
                                    >
                                        3 - Good
                                    </option>

                                    <option
                                        value="2"
                                        @selected(old('rating') == 2)
                                    >
                                        2 - Fair
                                    </option>

                                    <option
                                        value="1"
                                        @selected(old('rating') == 1)
                                    >
                                        1 - Poor
                                    </option>

                                </select>

                            </div>


                            <div class="form-group full">

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

                        </div>


                        <div class="review-form-actions">

                            <button
                                type="submit"
                                class="primary-button"
                            >
                                Submit Review
                            </button>

                        </div>

                    </form>

                </div>

            @elseif(auth()->user()->isCustomer())

                <div class="review-message-card">

                    <div>

                        <strong>
                            Email verification required
                        </strong>

                        <p>
                            Please verify your email address before submitting a review.
                        </p>

                    </div>

                </div>

            @endif

        @else

            <div class="review-message-card">

                <div>

                    <strong>
                        Have you tried this product?
                    </strong>

                    <p>
                        Log in as a customer to share your experience.
                    </p>

                </div>

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

                            <div class="review-author">

                                <div class="review-avatar">
                                    {{ strtoupper(substr($review->user->first_name, 0, 1)) }}
                                </div>

                                <div>

                                    <strong>
                                        {{ $review->user->fullName() }}
                                    </strong>

                                    <div class="review-rating">
                                        <span class="rating-stars">
                                            {{ str_repeat('★', $review->rating) }}
                                        </span>

                                        <span class="rating-number">
                                            {{ $review->rating }}/5
                                        </span>
                                    </div>

                                </div>

                            </div>


                            <span class="review-date">
                                {{ $review->created_at->format('M d, Y') }}
                            </span>

                        </div>


                        <p class="review-content">
                            {{ $review->review }}
                        </p>

                    </article>

                @endforeach

            </div>

        @endif

    </section>

</section>

@endsection