@extends('layouts.dashboard')

@section('title', 'Freshness Change Requests')

@section('content')

<div class="workspace-header">

    <div>
        <h1>Freshness Change Requests</h1>

        <p>
            Review vendor requests to modify locked product freshness information.
        </p>
    </div>

</div>


<section class="vendor-dashboard-card product-management-card">

    <div class="vendor-dashboard-card-header">

        <div>
            <span class="muted-label">
                Freshness Management
            </span>

            <h2>
                Vendor Requests
            </h2>
        </div>

        <span class="badge">
            {{ $requests->count() }}
            {{ $requests->count() === 1 ? 'Request' : 'Requests' }}
        </span>

    </div>


    <div class="table-wrap">

        <table class="data-table">

            <thead>

                <tr>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Current</th>
                    <th>Requested</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>

            </thead>


            <tbody>

                @forelse($requests as $request)

                    <tr>

                        <td>

                            <strong>
                                {{ $request->product->name }}
                            </strong>

                        </td>


                        <td>

                            <strong>
                                {{ $request->vendor->fullName() }}
                            </strong>

                            <small>
                                {{ $request->vendor->store_name }}
                            </small>

                        </td>


                        <td>

                            {{ $request->current_arrival_date?->format('d/m/Y') }}

                            <br>

                            <small>
                                {{ $request->current_shelf_life_days }} days
                            </small>

                        </td>


                        <td>

                            {{ $request->requested_arrival_date?->format('d/m/Y') }}

                            <br>

                            <small>
                                {{ $request->requested_shelf_life_days }} days
                            </small>

                        </td>


                        <td>

                            <div class="freshness-request-reason">
                                {{ $request->reason }}
                            </div>

                        </td>


                        <td>

                            <span class="badge
                                        {{ $request->status === 'pending' ? 'warning' : '' }}
                                        {{ $request->status === 'denied' ? 'danger' : '' }}"
                                >
                                    {{ ucfirst($request->status) }}
                                </span>

                        </td>


                        <td>

                            {{ $request->created_at?->format('d/m/Y H:i') }}

                        </td>


                        <td>

                            @if($request->status === 'pending')

                                <div class="freshness-request-actions">

                                    <form
                                        method="POST"
                                        action="{{ route('admin.freshness-requests.approve', $request) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="text"
                                            name="admin_note"
                                            placeholder="Optional note"
                                        >

                                        <button
                                            type="submit"
                                            class="primary-button"
                                        >
                                            Approve
                                        </button>

                                    </form>


                                    <form
                                        method="POST"
                                        action="{{ route('admin.freshness-requests.deny', $request) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="text"
                                            name="admin_note"
                                            placeholder="Reason for denial"
                                            required
                                        >

                                        <button
                                            type="submit"
                                            class="secondary-button danger"
                                        >
                                            Deny
                                        </button>

                                    </form>

                                </div>

                            @else

                                <div class="freshness-request-reviewed">

                                    <span
                                        class="badge {{ $request->status === 'denied' ? 'danger' : '' }}"
                                    >
                                        {{ ucfirst($request->status) }}
                                    </span>

                                    @if($request->reviewed_at)

                                        <small>
                                            Reviewed
                                            {{ $request->reviewed_at->format('d/m/Y H:i') }}
                                        </small>

                                    @endif

                                </div>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8">

                            <div class="empty-state">

                                <h3>
                                    No freshness requests
                                </h3>

                                <p>
                                    There are currently no freshness change
                                    requests to review.
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