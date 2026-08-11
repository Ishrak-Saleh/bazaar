@extends('layouts.public')

@section('title', 'Login - Bazaar')

@section('content')
<section class="auth-shell">
    <div class="auth-card">
        <h1>Welcome Back</h1>
        <p>Login to continue shopping or manage your vendor dashboard.</p>

        <form method="POST" action="{{ route('login.store') }}" class="auth-form">
            @csrf

            <label>
                Email
                <input
                    type="email"
                    name="email"
                    required
                    value="{{ old('email') }}"
                >
            </label>

            <label>
                Password
                <input
                    type="password"
                    name="password"
                    required
                >
            </label>

            <div class="auth-links">
                <a href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            </div>

            <label class="checkbox-row">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <button type="submit" class="primary-button full">
                Login
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ route('register') }}">Create new account</a>
        </div>
    </div>
</section>
@endsection
