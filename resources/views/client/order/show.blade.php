@extends('layouts.client')
@section('content')

    <div class="text-center">
        <h1>Your Order</h1>
    </div>

    @if ($orders)
        @foreach ($orders as $order)
            <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
            <p>{{ auth()->user()->mobile_number }}</p>
            <p>{{ $order->order_number }}</p>
            <p>{{ $order->created_at }}</p>
            <p>{{ $order->status }}</p>
            <p>{{ $order->payment_method }}</p>
            <p>{{ $order->reference_number }}</p>
            <p>{{ $order->delivery_option }}</p>
            @foreach ($user->cart->where('order_number', $order->order_number) as $item)
                <img class="w-25 img-fluid" src="{{ asset($item->product->img) }}" alt="product picture">
                <p>{{ $item->product->name }}</p>
                <p>{{ $item->price }}</p>
                <p>{{ $item->quantity }}</p>
                <p>{{ $item->total }}</p>
            @endforeach
            <p>{{ $order->grand_total }}</p>
          <a href=""></a>
        @endforeach
    @else
        <div class="empty block ml-[32%] mt-28 text-[#5f9ea0] justify-center text-center items-center">
            <img src="{{ asset('images/empty.png') }}" class="w-28 ml-[20%]" alt="">
            <div class="w-2/4 text-xl font-semibold text-center pt-5 pl-10">
                <h1>NO ORDERS</h1>
            </div>
        </div>
    @endif
    </div>

    </section>

@endsection
