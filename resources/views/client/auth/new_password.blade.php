@extends('layouts.client')
@section('content')
   
    <form method="POST" action="{{ URL::secure(route('reset_password.verify-new-password', ['token' => $token,  'email' => $email])) }}">
        @csrf
        <label for="password" class="form-label">New Password:</label>
        <input type="password" class="form-control" name="password" id="password" required>
        @error('password')
            <p>{{ $message }}</p>
        @enderror
        <label for="password_confirmation" class="form-label">Confirm Password:</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        @error('password_confirmation')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
