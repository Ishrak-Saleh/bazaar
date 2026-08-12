@extends('layouts.dashboard')

@section('title', 'My Products')

@section('content')

<div class="workspace-header">

    <div>
        <h1>My Products</h1>
        <p>Manage your marketplace listings and inventory.</p>
    </div>

    <a
        href="{{ route('vendor.products.create') }}"
        class="primary-button"
    >
        New Product
    </a>

</div>


<section class="vendor-dashboard-card product-management-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">Catalog</span>
            <h2>Product Inventory</h2>
        </div>

        <span class="badge">
            {{ $products->count() }}
            {{ $products->count() === 1 ? 'Product' : 'Products' }}
        </span>

    </div>


    <div class="table-wrap">

        <table class="data-table">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Arrival Date</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>State</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($products as $product)

                    <tr>

                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td>
                            {{ $product->category->name }}
                        </td>

                        <td>
                            {{ optional($product->arrival_date)->format('d/m/Y') }}
                        </td>

                        <td>
                            ৳{{ number_format($product->price, 0) }}
                        </td>

                        <td>
                            {{ $product->stock }}
                        </td>

                        <td>
                            <span class="badge {{ $product->is_active ? '' : 'warning' }}">
                                {{ $product->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>

                        <td class="action-row">

                            <a
                                href="{{ route('vendor.products.edit', $product) }}"
                                class="secondary-button"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('vendor.products.destroy', $product) }}"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    class="secondary-button danger"
                                    type="submit"
                                >
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <h3>No products yet</h3>

                                <p>
                                    Create your first product to begin building
                                    your Bazaar storefront.
                                </p>

                                <a
                                    href="{{ route('vendor.products.create') }}"
                                    class="primary-button"
                                >
                                    Create Product
                                </a>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection