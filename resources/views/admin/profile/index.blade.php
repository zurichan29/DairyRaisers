@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.profile.update-avatar') }}" class="mb-3" method="POST" enctype="multipart/form-data">
        @csrf
        <img class=" rounded-circle" style="width: 50px" src="{{ Storage::url($profile->img) }}">
        <div class="mb-3">
            <label for="formFile" class="form-label">Change Avatar</label>
            <input class="form-control" type="file" name="avatar" id="formFile">
        </div>
        @error('avatar')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary">Update Avatar</button>
    </form>

    <form action="{{ route('admin.profile.update-password') }}" method="POST">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                value="{{ $profile->name }}" disabled readonly>
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="email"
                value="{{ $profile->email }}" disabled readonly>
            <label for="email">Email</label>
        </div>
        <div class="">
            <h6>Access:</h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="access-list">
                        @foreach ($accessData as $access)
                            @if ($loop->iteration % 2 !== 0)
                                <li>{{ $access }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="access-list">
                        @foreach ($accessData as $access)
                            @if ($loop->iteration % 2 === 0)
                                <li>{{ $access }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="form-floating mb-3">
            <label for="current_password">{{ __('Current Password') }}</label>
            <input id="current_password" type="password" class="form-control" name="current_password"
                placeholder="Current Password" required>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <label for="new_password">{{ __('New Password') }}</label>
            <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password"
                required>
            @error('new_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation"
                placeholder="New Password Confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
