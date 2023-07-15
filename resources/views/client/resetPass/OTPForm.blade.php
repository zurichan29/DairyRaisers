@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <form method="POST" action="{{ URL::secure(route('forgot_password.otp.validate')) }}">
        @csrf
        <h1>very sms to {{ session('reset_password.number') }}</h1>
        <label for="otp">ENTER OTP</label>
        <input type="number" name="otp" id="otp" required>
        @error('otp')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">submit</button>
    </form>

    <!-- Resend code functionality -->
    <form action="{{ URL::secure(route('forgot_password.otp.resend')) }}" method="POST">
        @csrf
        @if (Session::has('resend_otp'))
            <div class="error">{{ Session::get('resend_otp') }}</div>
        @endif
        <button type="submit">Resend Code</button>
    </form>
    @include('client.components.footer')
@endsection
