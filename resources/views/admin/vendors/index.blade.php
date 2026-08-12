@extends('layouts.dashboard')

@section('title', 'Manage Vendors')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Manage Vendors</h1>

        <p>
            Review vendor applications and manage marketplace access.
        </p>
    </div>

</div>


<section class="vendor-dashboard-card product-management-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">
                Vendor Management
            </span>

            <h2>
                Vendor Applications
            </h2>
        </div>

        <span class="badge">
            {{ $vendors->count() }}
            {{ $vendors->count() === 1 ? 'Vendor' : 'Vendors' }}
        </span>

    </div>


    <div class="table-wrap">

        <table class="data-table">

            <thead>

                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

            </thead>


            <tbody>

                @forelse($vendors as $vendor)

                    <tr>

                        <td>
                            <strong>
                                {{ $vendor->fullName() }}
                            </strong>
                        </td>


                        <td>
                            {{ $vendor->email }}
                        </td>


                        <td>
                            {{ $vendor->store_name }}
                        </td>


                        <td>

                            <span class="badge {{ $vendor->vendor_status === 'approved' ? '' : 'warning' }}">
                                {{ ucfirst($vendor->vendor_status) }}
                            </span>

                        </td>


                        <td class="action-row">

                            <form
                                method="POST"
                                action="{{ route('admin.vendors.approve', $vendor) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    class="secondary-button"
                                    type="submit"
                                >
                                    Approve
                                </button>

                            </form>


                            <form
                                method="POST"
                                action="{{ route('admin.vendors.reject', $vendor) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    class="secondary-button danger"
                                    type="submit"
                                >
                                    Reject
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5">

                            <div class="empty-state">

                                <h3>
                                    No vendors found
                                </h3>

                                <p>
                                    There are currently no vendor applications
                                    to display.
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