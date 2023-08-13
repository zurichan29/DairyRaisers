@extends('layouts.admin')

@section('content')
{{-- action="{{ route('admin.profile.update-password') }}" method="POST" --}}
    <form id="adminProfileForm" class="container" >
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
            <input id="current_password" type="password" class="form-control" name="current_password"
            placeholder="Current Password" required>
            <label for="current_password">{{ __('Current Password') }}</label>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password"
            required>
            <label for="new_password">{{ __('New Password') }}</label>
            @error('new_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation"
            placeholder="New Password Confirmation" required>
            <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#adminProfileForm').submit(function(e) {
                e.preventDefault();


            });
        });
    </script>
@endsection
