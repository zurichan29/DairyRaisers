@extends('layouts.client')
@section('content')

    <!-- verify-mobile.blade.php -->
    <form action="{{ URL::secure(route('register.verify-otp.validate')) }}" method="POST">
        @csrf
        <h1>OTP sent to {{ session('register.mobile_number') }}</h1>
        <p>{{ session('register.mobile_verify_otp') }}</p>
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" required>
        @error('otp')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">Verify</button>
    </form>

    <!-- Resend code functionality -->
    <form action="{{ URL::secure(route('register.verify-otp.resend')) }}" method="POST">
        @csrf
        @if (Session::has('resend_otp'))
            <div class="error">{{ Session::get('resend_otp') }}</div>
        @endif
        <button type="submit">Resend Code</button>
    </form>

@endsection
