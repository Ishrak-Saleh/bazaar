@extends('layouts.public')

@section('title', $product->name . ' - Bazaar')

@section('content')
<section class="detail-shell">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <a href="{{ route('home') }}?category={{ $product->category->slug }}">{{ $product->category->name }}</a>
        <span>›</span>
        <span>{{ $product->name }}</span>
    </div>

    <div class="detail-grid">
        <div class="detail-image-card">
            <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : asset('images/placeholder-product.svg') }}" alt="{{ $product->name }}">

        <div class="detail-info-card">
            <div class="meta-row">
                <span class="category-chip">{{ $product->category->name }}</span>
                <span class="stock-chip {{ $product->stock > 0 ? 'in' : 'out' }}">In Stock ({{ $product->stock }} available)</span>
            </div>
            <h1>{{ $product->name }}</h1>
            <div class="price-row big">
                <span class="price">৳{{ number_format($product->price, 0) }}</span>
                <span class="price-unit">/ kg</span>
            </div>
            <p class="detail-copy">{{ $product->description }}</p>

            <div class="vendor-panel">
                <div class="vendor-label">Vendor</div>
                <div class="vendor-name">{{ $product->vendor->store_name ?? $product->vendor->fullName() }}</div>
            </div>

            <div class="spec-grid">
                <div class="spec-card"><strong>Origin Zone</strong><span>Bangladesh</span></div>
                <div class="spec-card"><strong>Cultivation</strong><span>Fresh Market</span></div>
                <div class="spec-card"><strong>Stock Class</strong><span>{{ $product->stock > 10 ? 'Stable' : 'Low' }}</span></div>
                <div class="spec-card"><strong>Weight</strong><span>Per kg</span></div>
            </div>

            <form method="POST" action="{{ route('cart.add', $product) }}" class="detail-action-card">
                @csrf
                <button type="submit" class="primary-button">Add To Shopping Cart</button>
            </form>
        </div>
    </div>
</section>
@endsection
