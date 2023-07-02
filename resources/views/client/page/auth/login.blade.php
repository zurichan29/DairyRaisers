<x-layout>
    @include('client.components.header')

    <section class="form-container pb-24 pt-16 flex items-center justify-center">

        <form
            class="w-[22rem] bg-[#5f9ea098] font-semibold text-center p-8 rounded-[1rem] shadow-[0_.5rem_1rem_rgba(0,0,0,0.6)]"
            method="POST" action="{{ route('authenticate') }}">

            <a><img src="{{ asset('images/Baka.png') }}" alt=""
                    class="logo w-[100px] hover:animate-pulse ml-[5.5rem]" /></a>
            <h1 class="mb-8 uppercase text-white font-semibold text-3xl">Login</h1>

            @csrf

            <label for="mobile_number"
                class="label text-white text-base flex items-center justify-center text-center">Enter your mobile
                number.</label>
            <div class="flex pt-2 pl-6 text-2xl">
                <span class="absolute pt-4 pl-5 text-[#5f9ea0] mr-2">+63 </span><input type="int" id="mobile_number"
                    name="mobile_number" value="{{ old('mobile_number') }}"
                    class="box w-[14rem] text-[#5f9ea0] rounded-[.5rem] ml-2 mt-2 mr-0 py-2 pl-16 pr-4 bg-[#fff8dcd7] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)]">
            </div>
            @error('mobile_number')
                <p class="text-red-500 text-xs mt-2 w-[18rem] absolute items-center justify-center text-center"> <i
                        class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i> {{ $message }}</p>
            @enderror

            <label for="password"
                class="label mt-12 text-white text-base flex items-center justify-center text-center">Password</label>
            <input type="password"
                class="box w-[14rem] rounded-[.5rem] mt-2 mr-2 py-2 px-4 text-2xl bg-[#fff8dcd7] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] text-[#5f9ea0]"
                name="password" value="{{ old('password') }}" />

            @error('password')
                <p class="text-red-500 text-xs mt-2 flex items-center justify-center text-center"> <i
                        class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i> {{ $message }}</p>
            @enderror

            <input type="submit" value="Login"
                class="btn capitalize w-full cursor-pointer pl-10 pr-10 mt-12 text-lg p-[.5rem] relative rounded-3xl text-white bg-[#d3a870] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)]"
                name="submit">

            <p class="have mt-4 text-[#fff8dc] text-lg block font-semibold"> Don't have an account?<a href="/register"
                    class="text-[#8b6a3e]"> Register</a></p>

        </form>
    </section>

    {{-- <section class="form-container min-h-screen flex items-center justify-center mt-16">

        <form class="w-[30rem] bg-[#5f9ea098] text-center p-8 rounded-[2rem] shadow-[0_.5rem_1rem_rgba(0,0,0,0.6)]"
            method="POST" action="{{ route('authenticate') }}">

            <h2 class="text-4xl text-white p-2 mb-4 uppercase font-bold">Login to Order</h2>

            @csrf

            <label for="mobile_number" class="label mt-2 ml-2 text-white text-lg flex">Mobile Number :</label>
            <input type="number"
                class="box w-full rounded-[.5rem] mt-2 mr-0 py-1 pl-4 text-[#8b6a3e] bg-[#fff8dcd7] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)]"
                name="mobile_number" value="{{ old('mobile_number') }}" />

            @error('mobile_number')
                <p class="text-red-500 text-xs mt-1 ml-8 flex">{{ $message }}</p>
            @enderror

            <label for="password" class="label mt-8 text-lg text-white flex ml-2">Password :</label>
            <input type="password"
                class="box w-full rounded-[.5rem] mt-2 mr-0 py-1 pl-4 text-[#8b6a3e] bg-[#fff8dcd7] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)]"
                name="password" value="{{ old('password') }}" />

            @error('password')
                <p class="text-red-500 text-xs mt-1 ml-8 flex">{{ $message }}</p>
            @enderror

            <div>
                <label for="remember">
                    <input type="checkbox" name="remember" id="remember"> Remember Me
                </label>
            </div>

            <input type="submit" value="Login"
                class="btn capitalize w-full cursor-pointer pl-10 pr-10 mt-16 text-lg p-[.5rem] relative rounded-3xl text-white bg-[#d3a870] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)]"
                name="submit">
            <a href="{{ URL::secure(route('forgot_password')) }}">Forgot your password?</a>
            <p class="have mt-8 text-[#fff8dc] text-xl block font-semibold"> Don't have an account?<a
                    href="{{ route('register') }}" class="text-[#8b6a3e]"> Register</a></p>
        </form>
    </section> --}}

    @include('client.components.footer')
</x-layout>
