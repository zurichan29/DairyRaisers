@extends('layouts.client')
@section('content')
    @include('client.components.header')

    <section class="form-container pb-24 pt-16 flex items-center justify-center">
        <div class="flex items-center justify-center gap-10 font-semibold w-[38rem] h-[25rem] bg-[#5f9ea098] text-center p-8 rounded-[1rem] shadow-[0_.5rem_1rem_rgba(0,0,0,0.6)]">
            <div class="">
                <a><img src="{{ asset('images/Baka.png') }}" alt="" class="logo flex w-[120px] hover:animate-pulse ml-5"/></a>
                <h1 class="mb-8 uppercase text-white font-semibold text-3xl">Login</h1>
                <p class="have mt-4 text-[#fff8dc] text-lg block font-semibold"> Don't have an account?<a href="/register"
                    class="text-[#8b6a3e]"> Register</a></p>
            </div>
            <form
                class="font-semibold text-center p-8"
                method="POST" action="{{ route('authenticate') }}">

                @csrf

                <label for="user_field"
                    class="label text-white text-base flex items-center justify-center text-center">Enter your mobile
                    number.</label>
                <div class="flex pt-2 pl-6 text-2xl">
                    <span class="absolute pt-4 pl-5 text-[#5f9ea0] mr-2">+63 </span><input type="string" id="user_field"
                        name="user_field" value="{{ old('user_field') }}"
                        class="box w-[14rem] text-[#5f9ea0] rounded-[.5rem] ml-2 mt-2 mr-0 py-2 pl-16 pr-4 bg-[#fff8dcd7] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)]">
                </div>
                @error('user_field')
                    <p class="text-red-500 text-xs mt-2 w-[18rem] absolute items-center justify-center text-center"> <i
                            class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i> {{ $message }}</p>
                @enderror

                <label for="password"
                    class="label mt-12 text-white text-base flex items-center justify-center text-center">Password</label>
                <input type="password"
                    class="box w-[14rem] rounded-[.5rem] mt-2 ml-5 py-2 px-4 text-2xl bg-[#fff8dcd7] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] text-[#5f9ea0]"
                    name="password" value="{{ old('password') }}" />

                @error('password')
                    <p class="text-red-500 text-xs mt-2 flex items-center justify-center text-center"> <i
                            class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i> {{ $message }}</p>
                @enderror
                
                <label for="remember">remember me</label>
                <input type="checkbox" name="remember" id="remember">
                <a href="{{ URL::secure(route('reset_password')) }}">Forgot your password?</a>
                <input type="submit" value="Login"
                    class="btn capitalize cursor-pointer ml-6 mt-12 bg-[#d3a870] py-2 px-8 text-white font-bold rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300"
                    name="submit">

            </form>
        </div>
    </section>

    

    @include('client.components.footer')
@endsection