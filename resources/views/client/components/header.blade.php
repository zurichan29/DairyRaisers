<header class=" inset-x-0 top-0 z-auto shadow-md bg-[#fff8dc] z-[1]">
    <div class="items-center flex justify-between p-1 mt-0 max-w-[1330px] relative">

        <a href="{{ URL::secure(route('index')) }}">
            <img src="{{ asset('images/Baka.png') }}" alt="" class="logo w-[75px] ml-3 hover:animate-pulse"/>
        </a>

        <a href="{{ URL::secure(route('index')) }}"
            class="logos text-[#c98c3e] text-[2.6rem] absolute ml-[90px] font-bold hover:animate-pulse">GTDRMPC</a>

        <nav class="navbar text-[16px] font-bold delay-75 uppercase text-[#5f9ea0] items-center text-center pl-[16%]">
            <div>
                <a href="{{ URL::secure(route('index')) }}" class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300">Home</a>
                <a href="{{ URL::secure(route('shop')) }}"
                    class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300">Products</a>
                <a href="{{ URL::secure(route('order_history')) }}"
                    class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white mr-10 delay-150 duration-300">Orders</a>
                <a class="inline-block mr-8">|</a>
                <a href="{{ URL::secure(route('about')) }}"
                    class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300">About</a>
                <a href="{{ URL::secure(route('contact')) }}"
                    class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300">Contact</a>
                <a href="{{ URL::secure(route('faqs')) }}"
                    class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300">FAQ<span
                        class="lowercase">s</span></a>
                <a href="{{ URL::secure(route('terms')) }}" class="px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300">Terms
                    of Services</a>
            </div>
        </nav>

        <div class="icons">
        </div>
        <div class="text-[1rem] font-bold">
            <button class="dropdown-button relative justify-center items-center">
                <a href="{{ URL::secure(route('cart')) }}" class="px-2 py-8 delay-150 duration-300"><i
                        class="fa-solid fa-cart-shopping text-[#5f9ea0] hover:text-[#deb887]"></i><span
                        class="text-white text-center bg-[#c98c3e] text-small pt-0 pr-[6px] rounded-full"
                        id="cart-count">
                        {{ $cartTotal }}
                        {{ $cartCount }}</span>
                </a>
                <div
                    class="dropdown-menu hidden absolute text-white border-dashed border-4 rounded-xl border-[#d3a870] font-semibold cursor-auto bg-[#5f9ea0] shadow-md mt-4 z-[1]">
                    <div
                        class="text-left w-[16.6rem] overflow-y-auto max-h-[36rem] flex-grow">
                        <div class="icons cart px-4">
                    
                            @if ($carts)
                                @foreach ($carts as $cart)
                                    @php
                                        $product = $cart->product;
                                    @endphp

                                    <div class="pb-6 pt-4 border-b-[.1rem] border-solid border-white">
                                        <div class="cart-item" data-cart-id="{{ $cart->id }}">
                                            <div class="grid grid-cols-3 gap-1 pb-2">
                                                <p class="pt-0 pr-0 text-sm">{{ $product->name }}</p>
                                                <div class="flex pb-4 ml-2 gap-1">

                                                    <a href=""
                                                        class="btn-decrease px-2 bg-[#c98c3e] text-white text-center rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">-</a>
                                                    <input type="number"
                                                        class="quantity-input w-8 rounded-lg border-0 text-[#d3a870] text-center text-sm"
                                                        value="{{ $cart->quantity }}">
                                                    <a href=""
                                                        class="btn-increase px-[.4rem] bg-[#c98c3e] text-white text-center rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">+</a>
                                                </div>
                                                <p class="ml-8 text-sm">₱ {{ $product->price }}</p>
                                            </div>



                                            <div class="grid grid-cols-2 gap-10">
                                                <a href=""
                                                    class="btn-remove text-xs bg-[#c98c3e] w-fit relative py-1 px-4 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                                                    Remove</a>
                                                <p class="text-sm ml-3">Total: ₱ <span
                                                        class="total">{{ $cart->total }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty block mt-16 text-white">
                                    <h1 class="text-white text-xl font-semibold text-center p-4">Cart is Empty</h1>
                                </div>
                                <a href="{{ URL::secure(route('cart')) }}"
                                    class="flex m-4 bg-[#c98c3e] items-center justify-center text-center py-2 px-5 text-white font-bold uppercase text-sm rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                                    Add Product</a>

                            @endif

                        </div>

                        <a href="{{ URL::secure(route('cart')) }}"
                            class="flex m-4 bg-[#c98c3e] items-center justify-center text-center py-2 px-5 text-white font-bold uppercase text-sm rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                            My Cart</a>

                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var dropdownButton = document.querySelector(".dropdown-button");
                        var dropdownMenu = document.querySelector(".dropdown-menu");

                        dropdownButton.addEventListener("mouseenter", function() {
                            dropdownMenu.style.display = "block";
                        });

                        dropdownButton.addEventListener("mouseleave", function() {
                            dropdownMenu.style.display = "none";
                        });
                    });
                </script>
            </button>

            @auth

                <a href="{{ URL::secure(route('profile')) }}" id="user-btn" class="fas fa-user text-[#5f9ea0] hover:text-[#deb887]">
                </a>

                <form class="inline" method="GET" action="{{ URL::secure(route('logout')) }}">
                    @csrf
                    <button type="submit"
                        class="text-[#5f9ea0] px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300"><i
                            class="fa-solid fa-door-closed"></i> Logout</button>
                </form>
            @else
                <a href="{{ URL::secure(route('register')) }}"
                    class=" text-[#5f9ea0] px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300"><i
                        class="fa-solid fa-user-plus"></i> Register</a>
                <a href="{{ URL::secure(route('login')) }}"
                    class="text-[#5f9ea0] px-2 py-8 hover:bg-[#5f9ea088] hover:text-white delay-150 duration-300"><i
                        class="fa-solid fa-right-to-bracket"></i> Login</a>

            @endauth
        </div>
    </div>
</header>
@if (Session::has('message'))
    <div id="flash-message"
        class="bg-green-500 text-white px-4 py-2 rounded flex items-center justify-center text-center">
        {{ Session::get('message') }}
    </div>
@endif
@if (Session::has('error'))
    <div id="flash-message"
        class="bg-red-500 text-white px-4 py-2 rounded flex items-center justify-center text-center">
        {{ Session::get('error') }}
    </div>
@endif

{{-- <header class=" inset-x-0 top-0 z-auto shadow-md bg-[#fff8dc] z-[100]">
        <div class="items-center flex justify-between p-1 mt-0 max-w-[1330px] relative">

            <a href="{{ URL::secure(route('index')) }}"><img src="{{ asset('images/Baka.png') }}" alt="" class="logo w-20 ml-4" /></a>

            <a href="{{ URL::secure(route('index')) }}" class="logos text-[#deb887] text-4xl text-right absolute ml-28 font-bold">G T D R M P C</a>

            <nav class="navbar mx-0.5 text-xl font-semibold delay-75 text-[#5f9ea0] items-center text-center pl-[13%]">
                <a href="{{ URL::secure(route('index')) }}" class="hover:text-[#deb887] pr-4">Home</a>
                <a href="{{ URL::secure(route('shop')) }}" class="hover:text-[#deb887] pr-4">Shop</a>
                <a href="{{ URL::secure(route('order_history')) }}" class="hover:text-[#deb887] pr-4">Orders</a>
                <a href="{{ URL::secure(route('about')) }}" class="hover:text-[#deb887] pr-4">About</a>
                <a href="{{ URL::secure(route('contact')) }}" class="hover:text-[#deb887] pr-4">Contact</a>
                <a href="{{ URL::secure(route('faqs')) }}" class="hover:text-[#deb887] pr-4">FAQs</a>
            </nav>

            <div class="icons cart">

                {{-- @if ($carts)
                    @foreach ($carts as $cart)
                        @php
                            $product = $cart->product;
                        @endphp
                        <div class="cart-item" data-cart-id="{{ $cart->id }}">
                            <p>{{ $cart->id }}</p>
                            <p>{{ $product->name }}</p>
                            <p>{{ $product->price }}</p>

                            <div class=" flex items-center mt-2">
                                <button class="btn-decrease">-</button>
                                <input type="number" class="quantity-input"
                                    value="{{ $cart->quantity }}">
                                <button class="btn-increase">+</button>
                            </div>

                            <p>total: <span class="total">{{ $cart->total }}</span></p>
                            <button class="btn-remove">remove</button>
                        </div>
                    @endforeach
                @else
                    <h1>cart is empty</h1>
                @endif --}}


{{-- <a href="{{ route('cart') }}" class="pr-4"><i
        class="fa-solid fa-cart-shopping text-xl text-[#5f9ea0] hover:text-[#deb887]"></i><span
        class="text-white bg-[#c98c3e] text-base pt-0 pr-1 rounded-full" id="cart-count">
        {{ $cartCount }}</span></a>

@auth

    <a href="{{ route('profile') }}" id="user-btn" class="fas fa-user text-xl text-[#5f9ea0] hover:text-[#deb887]"></a>

    <form class="inline text-xl" method="GET" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-[#5f9ea0] hover:text-[#deb887] font-semibold"><i
                class="fa-solid fa-door-closed"></i> Logout</button>
    </form>
@else
    <a href="/register" class="text-xl text-[#5f9ea0] hover:text-[#deb887] font-semibold pr-4"><i
            class="fa-solid fa-user-plus"></i> Register</a>
    <a href="/login" class="text-xl text-[#5f9ea0] hover:text-[#deb887] font-semibold"><i
            class="fa-solid fa-right-to-bracket"></i> Login</a>

@endauth
</div>
</div>
</header>
@if (Session::has('message'))
    <div id="flash-message" class="bg-green-500 text-white px-4 py-2 rounded">
        {{ Session::get('message') }}
    </div>
@endif
@if (Session::has('error'))
    <div id="flash-message" class="bg-red-500 text-white px-4 py-2 rounded">
        {{ Session::get('error') }}
    </div>
@endif --}} 
