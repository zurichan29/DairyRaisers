@extends('layouts.admin')

@section('content')
    <link href="{{ asset('css/order-print.css') }}" rel="stylesheet" media="print">
    <style>
        @media print {
            .exclude-print {
                display: none;
            }
        }
    </style>
    <div id="printableContent" class="card container shadow">
        <a href="{{ route('admin.orders.index') }}"
            class="position-absolute top-0 start-0 ml-4 mt-4 btn btn-secondary exclude-print">Back</a>
        <div class="card-header d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('images/company-logo.png') }}" class="img-fluid" style="width: 80px" alt="company logo">
            <p class="card-title fw-bold fs-4">General Trias Dairy Raisers Multi-Purpose Cooperative</p>
            <p class="mb-0">Santiago, General Trias, 4107 Philippines</p>
            <p> gentridairympc@ymail.com | +63 997 251 4142</p>
        </div>
        <div class="card-body mb-2">
            <p class="fw-bold fs-4 text-center mb-4">ORDER INVOICE</p>
            <div class="row">
                <div class="col">
                    <p>Order No.: {{ $order->order_number }}</p>
                    <p>Email: {{ $order->email }}</p>
                    <p>Address: {{ $order->address }}</p>
                    <p>Phone No: +63{{ $order->mobile_number }}</p>      
                </div>
                <div class="col">
                    <p>Reference No.: <span id="ref">{{ $order->reference_number }}</span></p>
                    <p>Paid Via: <span
                            class="badge badge-success fs-6">{{ $order->payment_method }}</span>
                    </p>
                    <p>Order Status: <span
                        class="badge badge-light fs-6">{{ $order->status }}</span>
                    </p>
                    <p>Method: <span
                            class="badge badge-light fs-6">{{ $order->shipping_option }}</span>
                    </p>
                </div>

            </div>
                 <br>
                <div class="row">
                    <h4 class="font-weight-bold">Grand Total (₱): {{ $order->grand_total . '.00' }}</h4>
                </div>           
        </div>
            
        <!-- Your invoice content goes here -->
        <!-- Use the data from the $order variable to populate the content -->
    </div>
@endsection
