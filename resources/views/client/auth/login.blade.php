@extends('layouts.client')
@section('content')

    <section class="form-container">
        <div class="wrapper" style="max-width: 350px; min-height: 400px; margin: 80px auto; padding: 40px 30px 30px 30px;
            background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
            <div class="logo" style=" width: 80px; margin: auto;">
                <img src="{{ asset('images/Baka.png') }}" alt="" style="width: 100%; height: 80px; object-fit: cover;
                    border-radius: 50%; box-shadow: 0px 0px 3px #5f5f5f, 0px 0px 0px 5px #ecf0f3, 8px 8px 15px #a7aaa7, -8px -8px 15px #fff;">
            </div>  
            <div class="text-center mt-4 name" style="font-weight: 600; font-size: 1.5rem; letter-spacing: 1.2px; color: #555;">
                Login
            </div>              
                <p class="have text-center mt-2"> Don't have an account?
                    <a href="/register" class="text-[#8b6a3e]"> Register</a>
                </p>

            <form class="p-3 mt-3"
                method="POST" action="{{ route('authenticate') }}">

                @csrf

                <label for="user_field" class="label">
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
                @enderror

                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                
                <input type="submit" value="Login" class="btn btn-primary mt-3" name="submit" style=" width: 100%; height: 40px;
                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                
                <div class="text-center mt-2">
                    <a href="{{ URL::secure(route('reset_password')) }}">Forgot your password?</a>
                </div>
            </form>
        </div>
    </section>

@endsection