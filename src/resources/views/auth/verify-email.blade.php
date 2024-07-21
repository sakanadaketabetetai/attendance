@extends('layouts.app')

@section('css')
@endsection

@section('content')
<h1>Verify Your Email Address</h1>

    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <p>Before proceeding, please check your email for a verification link.</p>
    <p>If you did not receive the email, click below to request another.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Resend Verification Email</button>
    </form>
@endsection