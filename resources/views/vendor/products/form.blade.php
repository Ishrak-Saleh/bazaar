@extends('layouts.dashboard')
@section('title', $mode === 'create' ? 'Create Product' : 'Edit Product')

@section('content')
<div class="workspace-header">
    <div>
        <h1>{{ $mode === 'create' ? 'Create Product' : 'Edit Product' }}</h1>
        <p>Theme-matched product editor for vendors.</p>
    </div>
</div>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="panel-card">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    <div class="form-grid">
        <label>Category
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
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

        <label>
            Arrival Date
            <input
                type="date"
                name="arrival_date"
                value="{{ old('arrival_date', optional($product->arrival_date)->format('Y-m-d')) }}"
                required>
        </label>

        <label>
            Estimated Shelf Life
            <select name="shelf_life_days" required>
                @foreach([3,5,7,10,14,21,30] as $days)
                    <option
                        value="{{ $days }}"
                        @selected(old('shelf_life_days', $product->shelf_life_days ?? 7) == $days)>
                        {{ $days }} Days
                    </option>
                @endforeach
            </select>
        </label>
        <label class="full">Description<textarea name="description" rows="6" required>{{ old('description', $product->description) }}</textarea></label>
        <label class="full">Image<input type="file" name="image"></label>
        <label class="full checkbox-row"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}> Active</label>
    </div>

    <button type="submit" class="primary-button">Save Product</button>
</form>
@endsection
