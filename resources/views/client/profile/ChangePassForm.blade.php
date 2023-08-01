@extends('layouts.client')
@section('content')

    <div style="max-width: 350px; min-height: 400px; margin: 80px auto; padding: 30px 30px 30px 30px;
        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">

        <form method="POST" action="{{ URL::secure(route('profile.change_password.validate')) }}">
            @csrf
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" style="width: 100%; border: none; outline: none; background: none;
                font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            @error('current_password')
                <p>{{ $message }}</p>
            @enderror

            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" style="width: 100%; border: none; outline: none; background: none;
                font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            @error('password')
                <p>{{ $message }}</p>
            @enderror

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" style="width: 100%; border: none; outline: none; background: none;
                font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            @error('password_confirmation')
                <p>{{ $message }}</p>
            @enderror

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 40px; border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                Submit
            </button>
        </form>
    </div>
@endsection