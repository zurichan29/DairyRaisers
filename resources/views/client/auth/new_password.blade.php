@extends('layouts.client')
@section('content')
   
    <form method="POST" action="{{ URL::secure(route('reset_password.verify_newpassword', ['number' => $number])) }}">
        @csrf
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        @error('password')
            <p>{{ $message }}</p>
        @enderror
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        @error('password_confirmation')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">Submit</button>
    </form>

@endsection
