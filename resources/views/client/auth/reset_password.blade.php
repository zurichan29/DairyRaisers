@extends('layouts.client')
@section('content')
    <nav class="" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('login') }}">Login</a></li>
            <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
        </ol>
    </nav>
    <form class="container-fluid my-5" style="max-width: 500px" method="POST"
        action="{{ route('reset_password.validate') }}">
        <div class="card shadow">
            <div class="card-header text-center">
                <h5 class="fw-bold">Reset your Account password</h5>
                <p>Enter your email address to reset your password. A password reset link will be sent to your email
                    address.</p>
            </div>
            <div class="card-body">
                @csrf
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control mb-3" name="email" id="email" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
