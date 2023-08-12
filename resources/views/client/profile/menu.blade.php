@extends('layouts.client')
@section('content')

    <div style="max-width: 350px; min-height: 400px; margin: 80px auto; padding: 30px 30px 30px 30px;
        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
        <p class="text-center" style="font-size: 25px">{{ auth()->user()->mobile_number }}</p>
        <form action="{{ route('edit.name') }}" method="POST">
            @csrf
            <div class="">
                <label for="first_name" class="form-label">First Name *</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ auth()->user()->first_name }}" required>
                 @error('first_name')
                     <p>{{ $message }}</p>
                 @enderror
            </div>
            <div class="">
                <label for="last_name" class="form-label">Last Name *</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ auth()->user()->last_name }}" required>
                 @error('last_name')
                     <p>{{ $message }}</p>
                 @enderror
            </div>
            <div class="">
                <label for="mobile_number" class="form-label">Mobile No. *</label>
                <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="{{ auth()->user()->mobile_number }}" required>
                 @error('mobile_number')
                     <p>{{ $message }}</p>
                 @enderror
            </div>

            <button type="submit" class="btn btn-primary">Change</button>
          
        </form>
        @if (auth()->user()->email)
            <p class="mt-4" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">{{ auth()->user()->email }}</p>
        @else
            <div class="text-center pt-2">
                <a href="{{ URL::secure(route('email.form')) }}">Create an email</a>
            </div>
        @endif

        <div class="mt-4" style="display:flex; column-gap: 7.5rem;">
            <div>
                <a href="{{ route('profile.address') }}">Go to Address</a>
            </div>
            <div class="">
                <a href="{{ route('profile.change_password') }}">Change Password</a>
            </div>
            <div>
                <a href="{{ url()->previous() }}">Go Back</a>
            </div>
        </div>
        <div class="text-center mt-5" style="padding-top:8px; align-items: center; width: 100%; height: 40px;
        border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
            <a href="{{ route('logout') }}">LOGOUT</a>
        </div>
    </div>
@endsection
