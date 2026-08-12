@extends('layouts.public')

@section('title', 'Login - Bazaar')

@section('content')

<section class="auth-page">

    <div class="auth-page-content">

        {{-- Brand / intro --}}
        <div class="auth-page-intro">

            <a
                href="{{ route('home') }}"
                class="auth-brand"
            >
                Bazaar<span>.</span>
            </a>

            <span class="auth-eyebrow">
                Welcome back
            </span>

            <h1>
                Continue your<br>
                Bazaar journey.
            </h1>

            <p>
                Sign in to shop fresh produce, track your orders,
                or manage your Bazaar account.
            </p>

            <a
                href="{{ route('home') }}"
                class="secondary-button auth-home-button"
            >
                Browse Marketplace
            </a>

        </div>


        {{-- Login card --}}
        <div class="auth-card auth-login-card">

            <div class="auth-card-header">

                <span class="muted-label">
                    Account Access
                </span>

                <h2>
                    Sign In
                </h2>

                <p>
                    Enter your account details to continue.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('login.store') }}"
                class="auth-form"
            >

                @csrf


                <label>
                    Email Address

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </label>


                <label>
                    Password

                    <input
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                </label>


                <div class="auth-form-row">

                    <label class="checkbox-row">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        <span>
                            Remember me
                        </span>

                    </label>


                    <a
                        href="{{ route('password.request') }}"
                        class="auth-inline-link"
                    >
                        Forgot password?
                    </a>

                </div>


                <button
                    type="submit"
                    class="primary-button full"
                >
                    Sign In
                </button>

            </form>


            <div class="auth-divider">
                <span>New to Bazaar?</span>
            </div>


            <a
                href="{{ route('register') }}"
                class="secondary-button full"
            >
                Create an Account
            </a>

        </div>

    </div>

</section>

@endsection