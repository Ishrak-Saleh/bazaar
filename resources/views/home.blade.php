    @extends('layouts.public')

    @section('title', 'Bazaar - Fresh Organic Produce')

    @section('content')
    <section class="hero-banner">
        <div class="hero-content">
            <h1 class="hero-title">Fresh, organic produce, delivered straight from the farm.</h1>
            <p class="hero-subtitle">Browse our carefully curated selection of organic groceries. Enjoy fresh, local produce delivered right to your door with guaranteed quality.</p>
        </div>
    </section>

    <section class="filter-dashboard">
        <form class="filter-wrapper" method="GET" action="{{ route('home') }}">
            <span class="filter-label">Filter by:</span>
            <div class="search-input-box">
                <input type="search" name="q" placeholder="Search for groceries..." value="{{ request('q') }}">
            </div>
            <select name="category" class="filter-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="pill-button" type="submit">Apply</button>
            <span class="result-pill">{{ $products->count() }} items found</span>
        </form>
    </section>

    <section class="product-section">
        <div class="product-grid">
            @forelse($products as $product)
                <article class="product-card">
                    <a href="{{ route('products.show', $product) }}" class="product-image-wrap">
                        @php
                            $image = $product->image_path
                                ? asset('storage/' . $product->image_path)
                                : asset('images/placeholder-product.svg');
                        @endphp

                        <img src="{{ $image }}" alt="{{ $product->name }}">
                    </a>
                    <div class="product-card-body">
                        <div class="meta-row">
                            <span class="category-chip">{{ $product->category->name }}</span>
                            <span class="stock-chip {{ $product->stock > 0 ? 'in' : 'out' }}">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                        </div>
                        <h3><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
                        <p class="product-snippet">{{ $product->description }}</p>
                        <div class="vendor-line">{{ $product->vendor->store_name ?? $product->vendor->name }}</div>
                        <div class="price-row">
                            <span class="price">৳{{ number_format($product->price, 0) }}</span>
                            <span class="price-unit">/ kg</span>
                        </div>
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <button type="submit" class="primary-button">+ Add To Cart</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="empty-state">No products found.</div>
            @endforelse
        </div>
    </section>
    @endsection
