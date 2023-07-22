@extends('layouts.client')
@section('content')

    @if ($orders)
        <div class="container-fluid pt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h4 class="mb-3 font-weight-normal text-center">Order History <i class="fas fa-shopping-cart ml-1"></i>
                    </h4>
                </div>
                <div class="row">
                    @foreach ($orders as $order)
                        @php
                            switch ($order->status) {
                                case 'Pending':
                                    $statusBadge = 'badge-info';
                                    $icon = 'fa-solid fa-spinner me-1';
                                    break;
                                case 'Approved':
                                    $statusBadge = 'badge-primary';
                                    $icon = 'fa-solid fa-thumbs-up me-1';
                                    break;
                                case 'Ready To Pick Up':
                                    $statusBadge = 'badge-warning';
                                    $icon = 'fa-solid fa-box-archive me-1';
                                    break;
                                case 'Delivered':
                                    $statusBadge = 'badge-success';
                                    $icon = 'fa-solid fa-circle-check me-1';
                                    break;
                                case 'Recieved':
                                    $statusBadge = 'badge-success';
                                    $icon = 'fa-solid fa-circle-check me-1';
                                    break;
                                default:
                                    break;
                            }
                            
                            switch ($order->delivery_option) {
                                case 'Delivery':
                                    $opt_icon = 'fa-solid fa-truck';
                                    break;
                                case 'Pick Up':
                                    $opt_icon = 'fa-solid fa-box-archive';
                                    break;
                                default:
                                    break;
                            }
                            
                        @endphp
                        <div class="col-md-12">
                            <div class="card">
                                <div class="dropdown ml-auto">
                                    <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                                        <a class="dropdown-item"
                                            href="{{ route('orders.show', ['id' => $order->id]) }}">view</a>
                                        <a class="dropdown-item"
                                            href="{{ route('orders.re-order', ['id' => $order->id]) }}">order again</a>
                                    </div>
                                </div>
                                <div class="card-body py-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <img style="width: 80px" class="img-fluid d-block mx-auto rounded"
                                                src="{{ asset($user->cart->where('order_number', $order->order_number)->first()->product->img) }}"
                                                alt="product image">
                                        </div>
                                        <div class="col-8">
                                            <h4 class="class="text-primary font-weight-bold">
                                                Order No. {{ $order->order_number }}
                                            </h4>
                                            <h6 class="font-weight-light">
                                                Date : {{ $order->updated_at }}
                                            </h6>
                                            <div class="col">
                                                <h5 class="badge badge-light text-center text-wrap py-2"><i
                                                        class="{{ $opt_icon }} me-1"></i> {{ $order->delivery_option }}
                                                </h5>
                                                <h5 class="badge {{ $statusBadge }} text-center text-wrap py-2"
                                                    style="width: 8rem;">
                                                    <i class="{{ $icon }}"></i>
                                                    {{ $order->status }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
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