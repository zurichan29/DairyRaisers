<x-layout>
    @include('client.components.header')

    <section class="icons carts">

        <div class="justify-center text-center items-center uppercase pb-10">
            <h1 class="title mt-10 mb-8 text-[#199696] text-5xl font-bold">Cart</h1>
            <div><a href="{{ route('shop') }}"
                    class="text-[#5f9ea0] hover:text-[#deb887] font-semibold text-base min-w-fit hover:underline">
                    <i class="fa-solid fa-angle-left"></i> Continue Shopping</a></div>
            @if ($cart)
                <div class="pt-10">
                    <div class="grid grid-cols-5 px-16 pb-5 border-b-[.1rem] shadow-md">
                        <h1 class="title text-left mt-10 ml-14 text-[#c98c3e] text-2xl font-bold">Product</h1>
                        <h1 class="title text-right mt-10 text-[#c98c3e] text-2xl font-bold">Price</h1>
                        <h1 class="title text-right mt-10 text-[#c98c3e] text-2xl font-bold">Quantity</h1>
                        <h1 class="title text-right mt-10 text-[#c98c3e] text-2xl font-bold">Total</h1>
                    </div>
                    @foreach ($cart as $item)
                        <div class="cart-item grid grid-cols-5 bg-white p-4 border-b-[.1rem] border-gray-300 grid grid-cols-4 gap-4 justify-center items-center text-right py-8"
                            data-cart-id="{{ $item['cartId'] }}">
                            {{-- INCLUDE THE PICTURE --}}
                           
                            <div>
                                <span class="text-[#c98c3e] text-xl font-semibold pb-2"> <img src="{{ asset($item['img']) }}" alt=""
                                    class="logo w-[100px] hover:animate-pulse ml-[4.5rem]" />{{ $item['name'] }}</span>
                            </div>
                            <div>
                                <span class="text-[#199696] text-xl font-bold pb-2">₱ {{ $item['price'] }}.00</span>
                            </div>
                            <div class=" flex pl-[8rem] mt-2">
                                <button
                                    class="btn-decrease px-3 py-1 bg-[#c98c3e] text-white text-center rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">-</button>
                                <input type="number"
                                    class="quantity-input w-12 rounded-lg text-xl font-semibold border-0 text-[#199696] text-center"
                                    value="{{ $item['quantity'] }}">
                                <button
                                    class="btn-increase px-[.6rem] py-1 bg-[#c98c3e] text-white text-center rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">+</button>
                            </div>
                            <div>
                                <span class="text-lg font-bold pr-12"><span class="text-xl text-[#199696]">₱ <span
                                            class="total">{{ $item['total'] }}</span>.00</span></span>
                            </div>
                            <div>
                                <button
                                    class="btn-remove mr-20 bg-[#c98c3e] w-fit relative py-2 px-6 text-white font-bold uppercase text-base rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.5)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 text-center ml-[420px] text-[#199696] text-2xl">
                    <span class="text-2xl font-bold ">Grand Total: <span class="ml-12">₱
                            <span class="grand-total">{{ $grand_total }}</span>.00</span></span>
                </div>


                <form method="GET" action="/checkout">
                    <div class="flex flex-wrap pl-[40%] pt-16 z-[1] gap-5">
                        <button type="submit"
                            class="btn mt-4 bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-base rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.5)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                            Checkout</button>
                    </div>
                </form>
            @else
                <div class="empty block ml-[32%] mt-20 text-[#5f9ea0] justify-center text-center items-center">
                    <img src="{{ asset('images/empty.png') }}" class="w-28 ml-[18%]" alt="">
                    <div class="w-2/4 text-xl font-semibold text-center p-4">
                        <h1>No Cart Item</h1>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- <section class="cart mt-32">
        @if ($cart)
            <div class="p-4">
                <h1 class="text-2xl font-bold mb-4">Cart</h1>

                <div class="grid grid-cols-4 gap-4">
                    @foreach ($cart as $item)
                        <div class="cart-item bg-white p-4 shadow-md" data-cart-id="{{ $item['cartId']  }}">
                            <span class="text-lg font-bold">{{ $item['name'] }}</span>
                            <span class="text-gray-500">{{ $item['price'] }}</span>

                            <div class=" flex items-center mt-2">
                                <button class="btn-decrease bg-gray-200 px-2 py-1 rounded-md text-gray-700">-</button>
                                <input type="number" class="quantity-inpu w-16 mx-2 border border-gray-300 text-centet"
                                    value="{{ $item['quantity'] }}">
                                <button class="btn-increase bg-gray-200 px-2 py-1 rounded-md text-gray-700">+</button>
                            </div>

                            <span class="text-lg font-bold">Total: <span
                                    class="total">{{ $item['total'] }}</span></span>
                            <button class="btn-remove">remove</button>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <span class="text-lg font-bold">Grand Total: <span
                            class="grand-total">{{ $grand_total }}</span></span>
                </div>
            </div>

            <form method="GET" action="{{ route('checkout') }}">
                <div class="flex flex-wrap pl-[40%] py-6 z-[1]">
                    <button type="submit"
                        class="btn capitalize px-[5rem] text-lg p-[.5rem] relative rounded-3xl text-white text-center bg-[#199696] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)]">
                        Checkout</button>
                </div>
            </form>
        @else
            <h1>No Cart Item</h1>
        @endif

    </section> --}}



    <div class="pt-[7%]">
        @include('client.components.footer')
        <script src="{{ asset('js/cart.js') }}"></script>
    </div>
</x-layout>
