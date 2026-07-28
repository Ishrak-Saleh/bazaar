@extends('layouts.public')

@section('title', 'Register - Bazaar')

@section('content')
<section class="auth-shell">
    <div class="auth-card wide">
        <h1>Create Account</h1>
        <p>Choose customer or vendor access. Vendor accounts will wait for approval.</p>

        <form method="POST" action="{{ route('register.store') }}" class="auth-form">
            @csrf
            <div class="form-grid">
                <label>First Name<input name="first_name" value="{{ old('first_name') }}" required></label>
                <label>Last Name<input name="last_name" value="{{ old('last_name') }}" required></label>
                <label>Email<input type="email" name="email" value="{{ old('email') }}" required></label>
                <label>Phone<input name="phone" value="{{ old('phone') }}"></label>
                <label>Password<input type="password" name="password" required></label>
                <label>Confirm Password<input type="password" name="password_confirmation" required></label>
                <label>Account Type
                    <select name="role" id="roleSelect" required>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                    </select>
                </label>
                <label id="storeNameField" class="hidden">Store Name<input name="store_name" value="{{ old('store_name') }}"></label>
            </div>
            <button type="submit" class="primary-button full">Create Account</button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">Already have an account?</a>
        </div>
    </div>
</section>
@endsection
