@extends('layouts.public')

@section('title', 'My Account - Bazaar')

@section('content')
<section class="page-wrap narrow">
    <div class="profile-layout">
        <aside class="profile-card">
            <div class="avatar-badge">{{ strtoupper(substr($user->first_name ?? 'U', 0, 1) . substr($user->last_name ?? 'U', 0, 1)) }}</div>
            <h2>{{ $user->fullName() }}</h2>
            <div class="status-pill soft">Premium Member</div>
            <nav class="profile-nav">
                <a class="active" href="{{ route('profile.edit') }}">Personal Profile</a>
                <a href="{{ route('orders.index') }}">Order Tracking</a>
                <a href="{{ route('home') }}">Back to Store</a>
            </nav>
        </aside>

        <form method="POST" action="{{ route('profile.update') }}" class="panel-card">
            @csrf
            @method('PUT')
            <h1 class="page-title small">Personal Details</h1>
            <div class="form-grid">
                <label>First Name <input name="first_name" value="{{ $user->first_name }}" required></label>
                <label>Last Name <input name="last_name" value="{{ $user->last_name }}" required></label>
                <label>Email Address <input value="{{ $user->email }}" disabled></label>
                <label>Phone Number <input name="phone" value="{{ $user->phone }}"></label>
                <label class="full">Street Address <input name="address" value="{{ $user->address }}"></label>
                <label>City <input name="city" value="{{ $user->city }}"></label>
                <label>Postal Code <input name="postal_code" value="{{ $user->postal_code }}"></label>
            </div>
            <div class="action-row">
                <button type="submit" class="primary-button">Save Profile</button>
            </div>
        </form>
    </div>
</section>
@endsection
