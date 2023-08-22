@extends('layouts.client')
@section('content')
    <form class="container py-5" method="POST" action="{{ route('authenticate') }}">
        @csrf

        <div class="row">
            <div class="col">
                <div class="card d-flex flex-fill h-100 shadow">
                    <div class="card-body">
                        @error('not_valid')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('name') }}" placeholder="name@example.com">
                            <label for="email">Email *</label>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" value="{{ old('password') }}">
                            <label for="password">Password *</label>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="d-grid d-flex justify-content-between align-items-stretch">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-right-to-bracket"></i>
                                Login</button>
                            <a href="{{ route('reset_password') }}" class="btn btn-outline-primary"><i
                                    class="fa-solid fa-arrows-rotate"></i> Reset Password</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card d-flex flex-fill h-100 bg-primary text-white" style="background-image: url('/images/art.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center h-100">
                        <p class="fs-3">LOGIN YOUR ACCOUNT</p>
                        <p>Don't have an account yet? <a href="{{ URL::secure(route('register')) }}"
                                class="link-underline-light text-white fw-bolder"><u>SIGNUP</u></a> here.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
