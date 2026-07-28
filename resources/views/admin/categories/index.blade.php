@extends('layouts.dashboard')
@section('title', 'Manage Categories')

@section('content')
<div class="workspace-header">
    <div>
        <h1>Manage Categories</h1>
        <p>Create and maintain product categories for filtering.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.categories.store') }}" class="panel-card compact-form">
    @csrf
    <div class="action-row">
        <input name="name" placeholder="New category name" required>
        <button type="submit" class="primary-button">Add Category</button>
    </div>
</form>

<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Name</th><th>Slug</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td class="action-row">
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                            @csrf
                            @method('PUT')
                            <input name="name" value="{{ $category->name }}">
                            <button type="submit" class="secondary-button">Update</button>
                        </form>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
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
