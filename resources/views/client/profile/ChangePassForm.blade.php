@extends('layouts.client')
@section('content')

    <form method="POST" action="{{ URL::secure(route('profile.change_password.validate')) }}">
        @csrf
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" required>
        @error('current_password')
            <p>{{ $message }}</p>
        @enderror

        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        @error('password')
            <p>{{ $message }}</p>
        @enderror

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        @error('password_confirmation')
            <p>{{ $message }}</p>
        @enderror

        <button type="submit">Submit</button>
    </form>

@endsection