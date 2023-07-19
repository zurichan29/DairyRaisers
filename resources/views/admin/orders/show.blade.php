@extends('layouts.admin')
@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">All Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->order_number }}</li>
        </ol>
    </nav>
    <ul class="nav nav-pills nav-fill flex-row mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-order-invoice-tab" data-bs-toggle="pill"
                data-bs-target="#pills-order-invoice" type="button" role="tab" aria-controls="pills-order-invoice"
                aria-selected="true"><i class="fa-solid fa-circle-info"></i> Order Invoice</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-manage-order-tab" data-bs-toggle="pill" data-bs-target="#pills-manage-order"
                type="button" role="tab" aria-controls="pills-manage-order" aria-selected="false"><i
                    class="fa-solid fa-gear"></i> Manage Order</button>
        </li>

    </ul>
    <div class="tab-content p-2" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-order-invoice" role="tabpanel"
            aria-labelledby="pills-order-invoice-tab" tabindex="0">
            <div class="row justify-content-center">
                <div class="col-md-7 d-flex align-self-stretch">
                    <div class="card w-100">
                        <div class="card-body d-flex and flex-column">
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach ($cart as $item)
                                        <div class="row align-items-center mb-4">
                                            <div class="col-3">
                                                <img src="{{ asset($item->product->img) }}" class="img-fluid"
                                                    alt="Item picture">
                                            </div>
                                            <div class="col-9">
                                                <h6 class="font-weight-normal">
                                                    {{ $item->product->name }}
                                                    <span class="text-secondary">
                                                        {{ ' | ' . $item->product->variant }}
                                                    </span>
                                                </h6>
                                                <div class="row gx-5">
                                                    <div class="col">
                                                        <div class="">
                                                            <h6 class="text-primary">
                                                                PHP {{ $item->price . '.00' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="">
                                                            <h6 class="text-primary">
                                                                {{ $item->quantity }} PCS
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="border-top mb-2"></div>
                                                <h4 class="font-weight-bold text-primary">
                                                    TOTAL : PHP {{ $item->price * $item->quantity . '.00' }}
                                                </h4>

                                            </div>
                                        </div>
                                    @endforeach
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
                                <h6>Name: {{ $user->first_name . ' ' . $user->last_name }}</h6>
                                <h6>Contact: +63{{ $user->mobile_number }}</h6>
                                <h6>Email : {{ $user->email ? $user->email : 'None' }}</h6>
                                <h6>Address : {{ $order->user_address }}</h6>
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
                                        <a href="{{ asset($order->payment_reciept) }}" data-fancybox="gallery"
                                            data-caption="Payment Reciept">
                                            <img src="{{ asset($order->payment_reciept) }}" class="img-fluid"
                                                alt="Image">
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-manage-order" role="tabpanel" aria-labelledby="pills-manage-order-tab"
            tabindex="0">
            <div class="">
                <p>this is manage order</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("[data-fancybox]").fancybox({
                thumbs: {
                    autoStart: true,
                    axis: 'x'
                },
                buttons: [
                    'zoom',
                    'slideShow',
                    'fullScreen',
                    'close'
                ]
            });
        });
    </script>
@endsection
