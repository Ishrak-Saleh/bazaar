@extends('layouts.dashboard')
@section('title', 'Manage Products')

@section('content')
<div class="workspace-header">
    <div>
        <h1>Manage Products</h1>
        <p>Admin-level catalog control across all vendors.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="panel-card">
    @csrf
    <h2>Create Product</h2>
    <div class="form-grid">
        <label>Vendor
            <select name="vendor_id" required>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->fullName() }} — {{ $vendor->store_name }}</option>
                @endforeach
            </select>
        </label>
        <label>Category
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Name<input name="name" required></label>
        <label>Price<input type="number" step="0.01" name="price" required></label>
        <label>Stock<input type="number" name="stock" required></label>
        <label class="full">Description<textarea name="description" rows="5" required></textarea></label>
        <label class="full">Image<input type="file" name="image"></label>
    </div>
    <button type="submit" class="primary-button">Create Product</button>
</form>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr><th>Name</th><th>Vendor</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->vendor->fullName() }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>৳{{ number_format($product->price, 0) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="action-row">
                        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="vendor_id" value="{{ $product->vendor_id }}">
                            <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="description" value="{{ $product->description }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="stock" value="{{ $product->stock }}">
                            <button type="submit" class="secondary-button">Quick Save</button>
                        </form>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="secondary-button danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
