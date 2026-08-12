@extends('layouts.dashboard')

@section('title', 'Manage Categories')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Manage Categories</h1>

        <p>
            Create and maintain product categories for filtering.
        </p>
    </div>

</div>


{{-- =========================================================
     ADD CATEGORY
========================================================= --}}

<section class="vendor-dashboard-card category-create-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">
                Catalog Structure
            </span>

            <h2>
                Add Category
            </h2>
        </div>

    </div>


    <form
        method="POST"
        action="{{ route('admin.categories.store') }}"
        class="category-create-form"
    >

        @csrf

        <input
            name="name"
            placeholder="New category name"
            required
        >

        <button
            type="submit"
            class="primary-button"
        >
            Add Category
        </button>

    </form>

</section>


{{-- =========================================================
     CATEGORY LIST
========================================================= --}}

<section class="vendor-dashboard-card product-management-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">
                Categories
            </span>

            <h2>
                Product Categories
            </h2>
        </div>

        <span class="badge">
            {{ $categories->count() }}
            {{ $categories->count() === 1 ? 'Category' : 'Categories' }}
        </span>

    </div>


    <div class="table-wrap">

        <table class="data-table">

            <thead>

                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>

            </thead>


            <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>
                            <strong>
                                {{ $category->name }}
                            </strong>
                        </td>


                        <td>
                            {{ $category->slug }}
                        </td>


                        <td class="action-row">

                            <form
                                method="POST"
                                action="{{ route('admin.categories.update', $category) }}"
                            >

                                @csrf
                                @method('PUT')

                                <input
                                    name="name"
                                    value="{{ $category->name }}"
                                    aria-label="Category name"
                                    required
                                >

                                <button
                                    type="submit"
                                    class="secondary-button"
                                >
                                    Update
                                </button>

                            </form>


                            <form
                                method="POST"
                                action="{{ route('admin.categories.destroy', $category) }}"
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

                        <td colspan="3">

                            <div class="empty-state">

                                <h3>
                                    No categories yet
                                </h3>

                                <p>
                                    Add a category to organize products
                                    across the Bazaar catalog.
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