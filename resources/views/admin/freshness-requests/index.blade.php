@extends('layouts.dashboard')

@section('title', 'Freshness Change Requests')

@section('content')

<div class="workspace-header">
    <div>
        <h1>Freshness Change Requests</h1>
        <p>Review vendor requests to modify locked product freshness information.</p>
    </div>
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
                        <strong>{{ $request->product->name }}</strong>
                    </td>

                    <td>
                        {{ $request->vendor->fullName() }}
                        <br>
                        <small>{{ $request->vendor->store_name }}</small>
                    </td>

                    <td>
                        {{ $request->current_arrival_date?->format('d/m/Y') }}
                        <br>
                        {{ $request->current_shelf_life_days }} days
                    </td>

                    <td>
                        {{ $request->requested_arrival_date?->format('d/m/Y') }}
                        <br>
                        {{ $request->requested_shelf_life_days }} days
                    </td>

                    <td>
                        {{ $request->reason }}
                    </td>

                    <td>
                        {{ ucfirst($request->status) }}
                    </td>

                    <td>
                        {{ $request->created_at?->format('d/m/Y H:i') }}
                    </td>

                    <td class="action-row">

                        @if($request->status === 'pending')

                            <form method="POST"
                                    action="{{ route('admin.freshness-requests.approve', $request) }}">
                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="text"
                                        name="admin_note"
                                        placeholder="Optional note"
                                    >

                                    <button type="submit" class="primary-button">
                                        Approve
                                    </button>
                            </form>

                            <form method="POST"
                                action="{{ route('admin.freshness-requests.deny', $request) }}">
                                @csrf
                                @method('PATCH')

                                <input
                                    type="text"
                                    name="admin_note"
                                    placeholder="Reason for denial"
                                >

                                <button type="submit" class="secondary-button danger">
                                    Deny
                                </button>
                            </form>

                        @else

                            <span>
                                {{ ucfirst($request->status) }}
                                @if($request->reviewed_at)
                                    <br>
                                    <small>
                                        {{ $request->reviewed_at->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </span>

                        @endif

                    </td>
                </tr>
            @empty

                <tr>
                    <td colspan="8">
                        No freshness change requests found.
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>

@endsection