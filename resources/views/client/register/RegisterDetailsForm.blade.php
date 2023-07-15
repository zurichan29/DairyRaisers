@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <!-- register-details.blade.php -->
    <h1>{{ session('register.mobile_number') }}</h1>
    <form action="{{ URL::secure(route('register.details.validate', ['mobile_number' => $mobile_number])) }}" method="POST">
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
        @error('first_name')
            <div class="error">{{ $message }}</div>
        @enderror
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
        @error('last_name')
            <div class="error">{{ $message }}</div>
        @enderror
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        @error('password_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Register</button>
    </form>

    @include('client.components.footer')
@endsection
