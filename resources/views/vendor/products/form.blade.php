@extends('layouts.dashboard')

@section('title', $mode === 'create' ? 'Create Product' : 'Edit Product')

@section('content')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="panel-card">
    @csrf

    @if($mode === 'edit')
        @method('PUT')
    @endif

    <div class="form-grid">

        <label>
            Category
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(old('category_id', $product->category_id) == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>
            Name
            <input
                name="name"
                value="{{ old('name', $product->name) }}"
                required>
        </label>

        <label>
            Price
            <input
                name="price"
                type="number"
                step="0.01"
                value="{{ old('price', $product->price) }}"
                required>
        </label>

        <label>
            Stock
            <input
                name="stock"
                type="number"
                value="{{ old('stock', $product->stock) }}"
                required>
        </label>


        {{-- FRESHNESS INFORMATION --}}
        @php
            $freshnessLocked =
                $mode === 'edit'
                && $product->freshness_locked_at
                && now()->greaterThanOrEqualTo($product->freshness_locked_at);
        @endphp


        <label>
            Arrival Date

            <input
                type="date"
                name="arrival_date"
                value="{{ old('arrival_date', optional($product->arrival_date)->format('Y-m-d')) }}"
                {{ $freshnessLocked ? 'disabled' : '' }}
                required>

            <small>
                @if($product->arrival_date)
                    Current: {{ $product->arrival_date->format('d/m/Y') }}
                @else
                    Enter the product arrival date.
                @endif
            </small>

            @if($freshnessLocked)
                <small>
                    Freshness information is locked.
                </small>
            @endif
        </label>


        <label>
            Estimated Shelf Life

            <select
                name="shelf_life_days"
                {{ $freshnessLocked ? 'disabled' : '' }}
                required>

                @foreach([3,5,7,10,14,21,30] as $days)
                    <option
                        value="{{ $days }}"
                        @selected(old('shelf_life_days', $product->shelf_life_days ?? 7) == $days)
                    >
                        {{ $days }} Days
                    </option>
                @endforeach

            </select>

            @if($freshnessLocked)
                <small>
                    Freshness information is locked.
                </small>
            @endif
        </label>


        <label class="full">
            Description

            <textarea
                name="description"
                rows="6"
                required>{{ old('description', $product->description) }}</textarea>
        </label>


        <label class="full">
            Product Image

            @if($mode === 'edit' && $product->image_path)

                <div class="current-product-image">

                    <img
                        src="{{ asset('storage/' . $product->image_path) }}"
                        alt="{{ $product->name }}"
                        class="current-product-image-preview"
                    >

                    <div class="current-product-image-info">

                        <strong>
                            Current Product Image
                        </strong>

                        <small>
                            Select a new image below to replace it.
                        </small>

                    </div>

                </div>

            @endif

            <input
                type="file"
                name="image"
                accept="image/*"
                id="productImageInput"
            >

            <small>
                @if($mode === 'edit' && $product->image_path)
                    Leave this empty to keep the current image.
                @else
                    Upload a product image.
                @endif
            </small>

        </label>


        <label class="full checkbox-row">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>

            Active
        </label>

    </div>


    {{-- NORMAL SAVE --}}
    <button type="submit" class="primary-button">
        Save Product
    </button>

</form>


{{-- FRESHNESS CHANGE REQUEST --}}
@if($mode === 'edit' && $freshnessLocked)

    <div class="panel-card" style="margin-top: 24px;">

        <h2>Freshness Information Locked</h2>

        <p>
            The 30-minute modification period for this product has expired.
            You can no longer directly change the arrival date or shelf life.
        </p>

        <button
            type="button"
            class="secondary-button"
            onclick="document.getElementById('freshness-request-form').style.display = 'block'; this.style.display = 'none';">
            Request Freshness Change
        </button>


        <div
            id="freshness-request-form"
            style="display: none; margin-top: 20px;">

            <form
                method="POST"
                action="{{ route('vendor.products.freshness-request.store', $product) }}">

                @csrf

                <div class="form-grid">

                    <label>
                        Requested Arrival Date

                        <input
                            type="date"
                            name="requested_arrival_date"
                            value="{{ old('requested_arrival_date', optional($product->arrival_date)->format('Y-m-d')) }}"
                            required>
                    </label>


                    <label>
                        Requested Shelf Life

                        <select name="requested_shelf_life_days" required>

                            @foreach([3,5,7,10,14,21,30] as $days)

                                <option
                                    value="{{ $days }}"
                                    @selected(old('requested_shelf_life_days', $product->shelf_life_days) == $days)
                                >
                                    {{ $days }} Days
                                </option>

                            @endforeach

                        </select>
                    </label>


                    <label class="full">
                        Reason for Change

                        <textarea
                            name="reason"
                            rows="5"
                            required
                            placeholder="Explain why the freshness information needs to be changed...">{{ old('reason') }}</textarea>
                    </label>

                </div>

                <button
                    type="submit"
                    class="primary-button">
                    Send Request to Admin
                </button>

            </form>

        </div>

    </div>

@endif

@endsection