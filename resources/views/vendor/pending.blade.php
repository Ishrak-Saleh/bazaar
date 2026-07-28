@extends('layouts.public')

@section('title', 'Vendor Approval Pending - Bazaar')

@section('content')
<section class="page-wrap narrow">
    <div class="panel-card">
        <h1 class="page-title small">Vendor Approval Pending</h1>
        <p>Your vendor application has been created. An admin must approve your account before you can access the vendor dashboard.</p>
        <p>If your account is already approved, log out and sign in again.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="primary-button" type="submit">Logout</button>
        </form>
    </div>
</section>
@endsection
