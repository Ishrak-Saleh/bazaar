@extends('layouts.dashboard')

@section('title', 'Manage Products')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Manage Products</h1>

        <p>
            Admin-level catalog control across all vendors.
        </p>
    </div>

</div>


<section class="vendor-dashboard-card product-management-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">
                Catalog
            </span>

            <h2>
                All Products
            </h2>
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
                    <th>Vendor</th>
                    <th>Category</th>
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
                            <strong>
                                {{ $product->name }}
                            </strong>
                        </td>


                        <td>
                            {{ $product->vendor->fullName() }}
                        </td>


                        <td>
                            {{ $product->category->name }}
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

                            <form
                                method="POST"
                                action="{{ route('admin.products.update', $product) }}"
                            >

                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="vendor_id"
                                    value="{{ $product->vendor_id }}"
                                >

                                <input
                                    type="hidden"
                                    name="category_id"
                                    value="{{ $product->category_id }}"
                                >

                                <input
                                    type="hidden"
                                    name="name"
                                    value="{{ $product->name }}"
                                >

                                <input
                                    type="hidden"
                                    name="description"
                                    value="{{ $product->description }}"
                                >

                                <input
                                    type="hidden"
                                    name="price"
                                    value="{{ $product->price }}"
                                >

                                <input
                                    type="hidden"
                                    name="stock"
                                    value="{{ $product->stock }}"
                                >

                                <button
                                    type="submit"
                                    class="secondary-button"
                                >
                                    Save
                                </button>

                            </form>


                            <form
                                method="POST"
                                action="{{ route('admin.products.destroy', $product) }}"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="secondary-button danger"
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

                                <h3>
                                    No products found
                                </h3>

                                <p>
                                    There are currently no products
                                    in the marketplace catalog.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection