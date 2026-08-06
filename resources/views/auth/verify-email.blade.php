@extends('layouts.public')

@section('title', 'Verify Your Email')

@section('content')
<section class="auth-section">
    <div class="auth-card">

        <h1>Verify Your Email</h1>

        <p>
            We've sent a verification link to your email address.
            Please check your inbox (and Spam folder if necessary), then click the verification link.
            After verifying your email, you can continue using Bazaar.
        </p>

        <hr class="my-4">

        <p class="text-sm text-gray-600">
            Didn't receive the email?
            Click the button below to send another verification email.
        </p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="primary-button">
                Resend Verification Email
            </button>
        </form>

    </div>
</section>
@endsection