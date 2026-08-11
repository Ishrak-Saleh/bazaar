@extends('layouts.public')

@section('title', 'Reset Password - Bazaar')

@section('content')

<section class="auth-shell">

    <div class="auth-card">

        <h1>Reset Password</h1>

        <p>
            Enter your new password below.
        </p>

        @if($errors->any())

            <div class="error-message">
                {{ $errors->first() }}
            </div>

        @endif

        <form
            method="POST"
            action="{{ route('password.update') }}"
            class="auth-form"
        >

            @csrf

            <input
                type="hidden"
                name="token"
                value="{{ $token }}"
            >

            <label>
                Email

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $email) }}"
                    required
                    autofocus
                >
            </label>

            <label>
                New Password

                <input
                    type="password"
                    name="password"
                    required
                >
            </label>

            <label>
                Confirm New Password

                <input
                    type="password"
                    name="password_confirmation"
                    required
                >
            </label>

            <button
                type="submit"
                class="primary-button full"
            >
                Reset Password
            </button>

        </form>

        <div class="auth-links">

            <a href="{{ route('login') }}">
                Back to Login
            </a>

        </div>

    </div>

</section>

@endsection