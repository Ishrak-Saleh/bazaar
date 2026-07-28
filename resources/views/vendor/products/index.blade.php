@extends('layouts.dashboard')
@section('title', 'My Products')

@section('content')
<div class="workspace-header">
    <div>
        <h1>My Products</h1>
        <p>Only your own marketplace items are shown here.</p>
    </div>
    <a href="{{ route('vendor.products.create') }}" class="primary-button">+ New Product</a>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>State</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>৳{{ number_format($product->price, 0) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->is_active ? 'Active' : 'Hidden' }}</td>
                    <td class="action-row">
                        <a href="{{ route('vendor.products.edit', $product) }}" class="secondary-button">Edit</a>
                        <form method="POST" action="{{ route('vendor.products.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button class="secondary-button danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
