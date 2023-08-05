@extends('layouts.client')
@section('content')

    <section class="icons carts">

        <div class="text-center mb-5">
            <h1 style="color:#007bff; margin-bottom:2rem; margin-top:1rem; text-transform:uppercase;">
                <strong>Cart</strong></h1>
                
            <div><a href="{{ route('shop') }}"
                    class="">
                    <i class="fa-solid fa-angle-left"></i> Continue Shopping</a></div>
            @if ($cart)
                <div class="mt-5">
                    <div class="text-center" style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); grid-gap: 2rem;">
                        <h1 class="title" style="font-size:25px;">Product</h1>
                        <h1 class="title" style="font-size:25px;">Price</h1>
                        <h1 class="title" style="font-size:25px;">Quantity</h1>
                        <h1 class="title" style="font-size:25px;">Total</h1>
                    </div>
                    <hr>
                    @foreach ($cart as $item)
                        <div class="cart-item"
                            data-cart-id="{{ $item['cartId'] }}" style="align-items: center; display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); grid-gap: 2rem;">
                            {{-- INCLUDE THE PICTURE --}}

                            <div style="display:flex;">
                                <span style="color:#007bff; font-size:20px;"> <img
                                        src="{{ asset($item['img']) }}" alt=""
                                        class="logo" />{{ $item['name'] }}</span>
                            </div>
                            <div>
                                <span class="text-[#199696] text-xl font-bold pb-2">₱ {{ $item['price'] }}.00</span>
                            </div>
                            <div class=" flex mt-2">
                                <button
                                    class="btn-decrease" style="width:30px; margin-right:.5rem;
                                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">-</button>
                                <input type="number"
                                    class="quantity-input text-center" style="width:80px; border: none; outline: none; background: none;
                                    font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                                    box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;"
                                    value="{{ $item['quantity'] }}">
                                <button
                                    class="btn-increase" style="width: 30px;  margin-left:.5rem;
                                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">+</button>
                            </div>
                            <div>
                                <span class="text-lg font-bold pr-12"><span class="text-xl text-[#199696]">₱ <span
                                            class="total">{{ $item['total'] }}</span>.00</span></span>
                            </div>
                            <div>
                                <button
                                    class="btn-remove" style="height: 40px;
                                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">Remove</button>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
                
                <div class="mt-4 text-center">
                    <span style="font-size:25px;">Grand Total: <span class="ml-12">
                            <span class="grand-total" style="color:#007bff;">₱ {{ $grand_total }}.00</span></span>
                </div>


                <form method="GET" action="/checkout">
                    <div class="">
                        <button type="submit"
                            class="btn btn-primary mt-4" style="height: 40px;
                            border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                            Checkout</button>
                    </div>
                </form>
            @else
                <div class="empty justify-center text-center items-center">
                    <img src="{{ asset('images/empty_cart.png') }}" alt="" style="width: ">
                    <div class="text-center pt-5">
                        <h1>No Cart Item</h1>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
