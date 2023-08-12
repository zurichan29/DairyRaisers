@extends('layouts.client')
@section('content')
    <section class="container">
        <div class="wrapper">
            <img src="{{ asset('images/Baka.png') }}" class="logo" alt="">
        </div>
        <div class="text-center mt-4">
            Login
        </div>
        <p class="have text-center mt-2"> Don't have an account?
            <a href="{{ route('register') }}" class="text-[#8b6a3e]"> Register</a>
        </p>

        <form class="p-3 mt-3" method="POST" action="{{ route('authenticate') }}">
            @error('not_valid')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            @csrf
            <div class="">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            {{-- <label for="user_field" class="label">
                    Enter Your Mobile Number
                </label>
                <div>
                    <span>+63 </span><input type="string" id="user_field" name="user_field" 
                    value="{{ old('user_field') }}" class="box" style="width: 14rem; border: none; outline: none; background: none;
                        font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                        box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">
                </div>
                @error('user_field')
                    <p class="text-red-500 text-xs mt-2 w-[18rem] absolute items-center justify-center text-center">
                         <i class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i> {{ $message }}</p>
                @enderror

                <label for="password"
                    class="label mt-4">Password</label>
                <div>
                    <input type="password" class="box" name="password" value="{{ old('password') }}" style="width: 16rem; border: none;
                    outline: none; background: none; font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 15px;
                    border-radius: 10px; box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;"/>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-2 flex items-center justify-center text-center">
                         <i class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i> {{ $message }}</p>
                @enderror --}}

            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>

            <input type="submit" value="Login" class="btn btn-primary mt-3" name="submit"
                style=" width: 100%; height: 40px;
                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">

            <div class="text-center mt-2">
                <a href="{{ URL::secure(route('reset_password')) }}">Forgot your password?</a>
            </div>
        </form>
        </div>
    </section>
@endsection
