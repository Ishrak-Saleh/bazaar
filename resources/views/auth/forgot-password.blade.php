@extends('layouts.public')

@section('title', 'Forgot Password - Bazaar')

@section('content')

<section class="auth-shell">

    <div class="auth-card">

        <h1>Forgot Password?</h1>

        <p>
            Enter your email address and we will send you a link
            to reset your password.
        </p>

        @if(session('success'))

            <div class="success-message">
                {{ session('success') }}
            </div>

        @endif

        @if($errors->any())

            <div class="error-message">
                {{ $errors->first() }}
            </div>

        @endif

        <form
            method="POST"
            action="{{ route('password.email') }}"
            class="auth-form"
        >

            @csrf

            <label>
                Email

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </label>

            <button
                type="submit"
                class="primary-button full"
            >
                Send Reset Link
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