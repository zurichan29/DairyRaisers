@extends('layouts.client')

@section('content')
    <form class="container " method="POST" action="{{ route('register.validate') }}">
        @csrf

        <div class="row ">
            <div class="col card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') }}" placeholder="first name">
                                <label for="first_name">First Name *</label>
                                @error('first_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') }}" placeholder="last name">
                                <label for="last_name">Last Name *</label>
                                @error('last_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('name') }}"
                            placeholder="name@example.com">
                        <label for="email">Email *</label>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">+63</span>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="mobile_number" name="mobile_number"
                                value="{{ old('mobile_number') }}" placeholder="last name">
                            <label for="mobile_number">Mobile No. *</label>
                        </div>
                        @error('mobile_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            value="{{ old('password') }}">
                        <label for="password">Password *</label>
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}" placeholder="Password">
                        <label for="password_confirmation">Confirm Password *</label>
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-grid d-flex justify-content-between align-items-stretch">
                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="{{ route('register.resend-token') }}" class="btn btn-outline-primary">Resend Token</a>
                    </div>
                </div>
            </div>
            <div class="col">
                asdasd
            </div>
        </div>
    </form>
@endsection