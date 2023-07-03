<x-layout>
    @include('client.components.header')

    <section class="order">

        <div class="custom-product">

            <div class="justify-center text-center items-center uppercase">
                <h1 class="title text-center my-10 text-[#199696] text-5xl font-bold">your order</h1>
            </div>

            @if ($user_order)
                @foreach ($user_order as $order)
                    <div class="shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] pb-10">
                        <div class="justify-center items-center py-4 pl-[25rem] font-xl font-semibold">
                            <h5 class="text-[#5f9ea0]">Name : <span class="d2691e">{{ $order['full_name'] }}</span>
                            </h5>
                            <h5 class="text-[#5f9ea0]">Mobile number : <span
                                class="d2691e">{{ $order['mobile_number'] }}</span>
                        </h5>
                            <h5 class="text-[#5f9ea0]">Order ID : <span class="d2691e">{{ $order['order_number'] }}</span>
                            </h5>
                            <h5 class="text-[#5f9ea0]">Order Placed : <span
                                    class="d2691e">{{ $order['created_at'] }}</span>
                            </h5>
                            <h5 class="text-[#5f9ea0]">Delivery Status : <span
                                    class="d2691e">{{ $order['delivery_status'] }}</span></h5>
                            <h5 class="text-[#5f9ea0]">Payment Method : <span
                                    class="d2691e">{{ $order['payment_method'] }}</span> : pending</h5>
                        </div>
                        @foreach ($order['cart_item'] as $item)
                            <div
                                class="row searched-item cart-list-divider grid grid-cols-6 gap-4 justify-center items-center pb-10 pl-[25rem]">

                                <div class="col-sm-3 ">
                                    <a href="detail/{{ $item['cartId'] }}">
                                        <img src="{{ $item['img'] }}"
                                            class="trending-img w-40 border-[.1rem] rounded-lg border-solid border-[#d3a870]">
                                    </a>
                                </div>

                                <div class="col-sm-4">
                                    <div class="">
                                        <h2 class="text-xl text-[#5f9ea0] pb-10">{{ $item['name'] }}</h2>
                                        <h2 class="text-[#d2691e] text-2xl font-semibold">₱ {{ $item['price'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-wrap gap-2 pl-[27%]">
                        <p class="option-btn text-xl text-center text-[#5f9ea0] w-[20rem]">Order Total: <span
                                class="text-[#d2691e] font-semibold text-2xl mb-4">₱ {{ $order['grand_total'] }}</span>
                        </p>
                    </div>
                @endforeach
            @else
                <div class="empty block ml-[32%] mt-28 text-[#5f9ea0] justify-center text-center items-center">
                    <img src="{{ asset('images/empty.png') }}" class="w-28 ml-[20%]" alt="">
                    <div class="w-2/4 text-xl font-semibold text-center pt-5 pl-10">
                        <h1>NO ORDERS</h1>
                    </div>
                </div>
            @endif

            {{-- @foreach ($order as $item)
                <div class="shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] pb-10">
                    <div class="justify-center items-center py-4 pl-[25rem] font-xl font-semibold">
                        <h5 class="text-[#5f9ea0]">Order Placed : <span class="d2691e">{{ $item->date }}</span></h5>
                        <h5 class="text-[#5f9ea0]">Delivery Status : <span class="d2691e">{{ $item->status }}</span></h5>
                        <h5 class="text-[#5f9ea0]">Payment Method : <span
                                class="d2691e">{{ $item->payment_method }}</span></h5>
                    </div>
                    <div
                        class="row searched-item cart-list-divider grid grid-cols-6 gap-4 justify-center items-center pb-10 pl-[25rem]">

                        <div class="col-sm-3 ">
                            <a href="detail/{{ $item->id }}">
                                <img src="{{ $item->img }}"
                                    class="trending-img w-40 border-[.1rem] rounded-lg border-solid border-[#d3a870]">
                            </a>
                        </div>

                        <div class="col-sm-4">
                            <div class="">
                                <h2 class="text-xl text-[#5f9ea0] pb-10">{{ $item->name }}</h2>
                                <h2 class="text-[#d2691e] text-2xl font-semibold">₱ {{ $item->price }}</h5>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-wrap gap-2 pl-[27%]">
                        <p class="option-btn text-xl text-center text-[#5f9ea0] w-[20rem]">Order Total: <span
                                class="text-[#d2691e] font-semibold text-2xl mb-4">₱ {{ $item->total }}</span></p>
                    </div>
                </div>
            @endforeach --}}

        </div>

    </section>


    <div class="pt-[10%]">
        @include('client.components.footer')
    </div>
</x-layout>
