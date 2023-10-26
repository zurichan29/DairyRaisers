@extends('layouts.client')

@section('content')
    <form class="container py-4" method="POST" action="{{ route('register.validate') }}">
        @csrf

        <div class="row">
            <div class="col">
                <div class="card d-flex flex-fill h-100 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" placeholder="first name">
                                    <label for="first_name" class="custom-floating-label">First Name *</label>
                                    @error('first_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}" placeholder="last name">
                                    <label for="last_name" class="custom-floating-label">Last Name *</label>
                                    @error('last_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('name') }}" placeholder="name@example.com">
                            <label for="email" class="custom-floating-label">Email *</label>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <div class="input-group mb-3">
                                <span class="input-group-text">+63</span>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="mobile_number" name="mobile_number"
                                        value="{{ old('mobile_number') }}" placeholder="last name">
                                    <label for="mobile_number" class="custom-floating-label">Mobile No. *</label>
                                </div>
                            </div>
                            @error('mobile_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" value="{{ old('password') }}">
                            <label for="password" class="custom-floating-label">Password *</label>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" value="{{ old('password_confirmation') }}"
                                placeholder="Password">
                            <label for="password_confirmation" class="custom-floating-label">Confirm Password *</label>
                            @error('password_confirmation')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="d-grid d-flex justify-content-between align-items-stretch">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i>
                                Register</button>
                            <a href="{{ route('register.resend-token') }}" class="btn btn-outline-primary"><i
                                    class="fa-solid fa-arrows-rotate"></i> Resend Code</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card d-flex flex-fill h-100 bg-primary text-white"
                    style="background-image: url('/images/art.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center h-100">
                        <p class="fs-3">REGISTER NOW AT DAIRY RAISERS!</p>
                        <p class="">Already have an account? <a href="{{ route('login') }}"
                                class="link-underline-light text-white fw-bolder"><u>LOGIN</u></a> here.</p>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
