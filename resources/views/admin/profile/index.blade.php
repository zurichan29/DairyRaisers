@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                value="{{ $profile->name }}">
            <label for="name">Name</label>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="email"
                value="{{ $profile->email }}" disabled readonly>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <label for="current_password">{{ __('Current Password') }}</label>
            <input id="current_password" type="password" class="form-control" name="current_password" placeholder="Current Password" required>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <label for="new_password">{{ __('New Password') }}</label>
            <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password" required>
            @error('new_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" placeholder="New Password Confirmation"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
@endsection
