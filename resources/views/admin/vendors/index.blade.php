@extends('layouts.dashboard')
@section('title', 'Manage Vendors')

@section('content')
<div class="workspace-header">
    <div>
        <h1>Manage Vendors</h1>
        <p>Approve or reject vendor applications.</p>
    </div>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr><th>Name</th><th>Email</th><th>Store</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->fullName() }}</td>
                    <td>{{ $vendor->email }}</td>
                    <td>{{ $vendor->store_name }}</td>
                    <td>{{ $vendor->vendor_status }}</td>
                    <td class="action-row">
                        <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}">
                            @csrf
                            @method('PATCH')
                            <button class="secondary-button" type="submit">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.vendors.reject', $vendor) }}">
                            @csrf
                            @method('PATCH')
                            <button class="secondary-button danger" type="submit">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
