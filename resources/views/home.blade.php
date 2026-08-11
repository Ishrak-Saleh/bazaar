@extends('layouts.public')

@section('title', 'Bazaar - Fresh Organic Produce')

@section('content')

<section class="hero-banner">
    <div class="hero-content">
        <h1 class="hero-title">
            Fresh, organic produce, delivered straight from the farm.
        </h1>

        <p class="hero-subtitle">
            Browse our carefully curated selection of organic groceries.
            Enjoy fresh, local produce delivered right to your door with guaranteed quality.
        </p>
    </div>
</section>


<section class="filter-dashboard">
    <form
        class="filter-wrapper"
        method="GET"
        action="{{ route('home') }}"
    >

        <span class="filter-label">Filter by:</span>

        <div class="search-input-box">
            <input
                type="search"
                name="q"
                placeholder="Search for groceries..."
                value="{{ request('q') }}"
                aria-label="Search for groceries"
            >
        </div>

        <select
            name="category"
            class="filter-select"
            aria-label="Filter by category"
        >
            <option value="">All Categories</option>

            @foreach($categories as $category)
                <option
                    value="{{ $category->slug }}"
                    @selected(request('category') === $category->slug)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button
            class="pill-button"
            type="submit"
        >
            Apply
        </button>

        @if(request('q') || request('category'))
            <a
                href="{{ route('home') }}"
                class="secondary-button"
            >
                Clear
            </a>
        @endif

        <span class="result-pill">
            {{ $products->count() }}
            {{ $products->count() === 1 ? 'item' : 'items' }}
            found
        </span>

    </form>
</section>


<section class="product-section">

    <div class="workspace-header catalog-header">
        <div>
            <h2>Fresh Produce</h2>

            <p>
                Quality products from our trusted vendors.
            </p>
        </div>
    </div>


    <div class="product-grid">

        @forelse($products as $product)

            <article class="product-card">

                {{-- Product image --}}
                <a
                    href="{{ route('products.show', $product) }}"
                    class="product-image-wrap"
                    aria-label="View {{ $product->name }}"
                >
                    @php
                        $image = $product->image_path
                            ? asset('storage/' . $product->image_path)
                            : asset('images/placeholder-product.svg');
                    @endphp

                    <img
                        src="{{ $image }}"
                        alt="{{ $product->name }}"
                        loading="lazy"
                    >
                </a>


                <div class="product-card-body">

                    {{-- Category + stock --}}
                    <div class="meta-row">

                        <span class="category-chip">
                            {{ $product->category->name }}
                        </span>

                        <span
                            class="stock-chip {{ $product->stock > 0 ? 'in' : 'out' }}"
                        >
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>

                    </div>


                    {{-- Freshness --}}
                    @php
                        $score = $product->freshness_score;

                        if ($score >= 80) {
                            $label = 'Excellent';
                            $color = '#22c55e';
                        } elseif ($score >= 60) {
                            $label = 'Fresh';
                            $color = '#84cc16';
                        } elseif ($score >= 40) {
                            $label = 'Average';
                            $color = '#f59e0b';
                        } else {
                            $label = 'Use Soon';
                            $color = '#ef4444';
                        }
                    @endphp


                    <div class="freshness-section">

                        <div class="freshness-header">
                            <span>Freshness</span>

                            <strong>
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

                        <small class="freshness-label">
                            {{ $label }}
                        </small>

                    </div>


                    {{-- Product name --}}
                    <h3 class="product-title">
                        <a
                            href="{{ route('products.show', $product) }}"
                        >
                            {{ $product->name }}
                        </a>
                    </h3>


                    {{-- Description --}}
                    <p class="product-snippet">
                        {{ $product->description }}
                    </p>


                    {{-- Vendor --}}
                    <div class="vendor-line">

                        <span>Sold by</span>

                        <strong>
                            {{ $product->vendor->store_name ?? $product->vendor->fullName() }}
                        </strong>

                    </div>


                    {{-- Price --}}
                    <div class="price-row">

                        <span class="price">
                            ৳{{ number_format($product->price, 0) }}
                        </span>

                        <span class="price-unit">
                            / kg
                        </span>

                    </div>


                    {{-- Add to cart --}}
                    <form
                        method="POST"
                        action="{{ route('cart.add', $product) }}"
                        class="product-cart-form"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="primary-button full"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                        >
                            Add to Cart
                        </button>
                    </form>

                </div>

            </article>

        @empty

            <div class="empty-state">
                <h3>No products found</h3>

                <p>
                    Try changing your search or category filter.
                </p>

                <a
                    href="{{ route('home') }}"
                    class="secondary-button"
                >
                    View All Products
                </a>
            </div>

        @endforelse

    </div>

</section>

@endsection