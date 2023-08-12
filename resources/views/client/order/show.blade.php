@extends('layouts.client')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('order_history') }}">All Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-7 d-flex align-self-stretch">
            <div class="card w-100">
                <div class="card-body d-flex and flex-column">
                    <div class="row">
                        <div class="col-md-12">
                            @auth
                                @foreach ($cart as $item)
                                    <x-order-display :name="$item['name']" :variant="$item['variant']" :price="$item['price']" :quantity="$item['quantity']"
                                        :total="$item['total']" :img="$item['img']" />
                                @endforeach
                            @else
                                @foreach ($cart as $item)
                                    <x-order-display :name="$item['name']" :variant="$item['variant']" :price="$item['price']" :quantity="$item['quantity']"
                                        :total="$item['total']" :img="$item['img']" />
                                @endforeach
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5  d-flex align-self-stretch">
            <div class="card w-100">
                <div class="card-body d-flex and flex-column">
                    <div class="">
                        <h5>
                            Customer Details <i class="fa-solid fa-circle-user text-primary"></i>
                        </h5>
                        <br>
                        @if ($order->customer_type == 'online_shopper')
                            <h6>Name: {{ $user->first_name . ' ' . $user->last_name }}</h6>
                            <h6>Contact: +63{{ $user->mobile_number }}</h6>
                            <h6>Email : {{ $user->email }}</h6>
                            <h6>Address : {{ $order->address }}</h6>
                        @elseif ($order->customer_type == 'guest')
                            <h6>Name: {{ $order->name }}</h6>
                            <h6>Contact: +63{{ $order->mobile_number }}</h6>
                            <h6>Address : {{ $order->address }}</h6>
                        @endif
                        <br>
                        <br>
                        <h5>
                            Invoice <i class="fa-solid fa-credit-card text-primary"></i>
                        </h5>
                        <br>
                        <h4 class="font-weight-bold">Grand Total (₱): {{ $order->grand_total . '.00' }}</h4>
                        <h6>Order No. {{ $order->order_number }}</h6>
                        <h6>Referenace No. {{ $order->reference_number }}</h6>
                        <br>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Paid Via: <span
                                        class="badge badge-success">{{ $order->payment_method }}</span>
                                </h6>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Order Status: <span
                                        class="badge {{ $statusBadge }}">{{ $order->status }}</span>
                                </h6>
                            </div>
                        </div>
                        <br>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="button" class="mx-auto text-center btn btn-sm btn-primary"
                                data-bs-toggle="collapse" data-bs-target="#PaymentReciept" aria-expanded="false"
                                aria-controls="PaymentReciept">View Payment Reciept</button>
                        </div>
                        <div class="collapse mt-3" id="PaymentReciept">
                            <div class="card card-body">
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" data-fancybox="gallery"
                                    data-caption="Payment Reciept">
                                    <img src="{{ asset('storage/' . $order->payment_receipt) }}" class="img-fluid"
                                        alt="Image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
