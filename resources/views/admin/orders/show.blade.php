@extends('layouts.admin')
@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <!-- Edit Modal -->
        <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOrderLabel">Edit Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editOrderForm" method="POST" action="{{ route('admin.orders.ref') }}">
                            @csrf
                            <input type="hidden" name="order_id" id="editOrderId">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ref" id="editOrderRef"
                                    placeholder="ref">
                                <label for="editOrderRef">Reference No. </label>
                                <div class="error-container-edit"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                <button class="nav-link" id="pills-manage-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-manage-order" type="button" role="tab" aria-controls="pills-manage-order"
                    aria-selected="false"><i class="fa-solid fa-gear"></i> Manage Order</button>
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
                                        @foreach ($order->items as $item)
                                            @if ($itemProduct = \App\Models\Product::find($item['product_id']))
                                                <div class="row align-items-center mb-4">
                                                    <div class="col-3">
                                                        <img src="{{ asset($itemProduct->img) }}" class="img-fluid"
                                                            alt="Item picture">
                                                    </div>
                                                    <div class="col-9">
                                                        <h6 class="font-weight-normal">
                                                            {{ $itemProduct->name }}
                                                            <span class="text-secondary">
                                                                {{ ' | ' . $itemProduct->variant->name }}
                                                            </span>
                                                        </h6>
                                                        <div class="row gx-5">
                                                            <div class="col">
                                                                <div class="">
                                                                    <h6 class="text-primary">
                                                                        ₱{{ $item['price'] . '.00' }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            @if ($order->customer_type == 'retailer')
                                                                <div class="col">
                                                                    <div class="">
                                                                        <h6 class="text-primary">
                                                                            ₱{{ $item['discount'] . '.00' }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="col">
                                                                <div class="">
                                                                    <h6 class="text-primary">
                                                                        {{ $item['quantity'] }} PCS
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="border-top mb-2"></div>
                                                        <h4 class="font-weight-bold text-primary">
                                                            TOTAL : ₱{{ $item['total'] . '.00' }}
                                                        </h4>

                                                    </div>
                                                </div>
                                            @else
                                                <br>
                                                Product not found
                                            @endif
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
                                    <div class="row">
                                        <div class="col ">
                                            <p class="">Name:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p class="">{{ $order->name }}</p>
                                        </div>
                                    </div>
                                    @if ($order->customer_type == 'retailer')
                                        <div class="row">
                                            <div class="col ">
                                                <p class="">Store:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="">{{ $order->store_name }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col ">
                                                <p class="">Email:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="">{{ $order->email }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col">
                                            <p class="">Mobile No.</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p class="">+63{{ $order->mobile_number }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="">Address:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p class="">{{ $order->address }}</p>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <br>
                                    <div style="display: flex; column-gap:8rem;">
                                        <h5>
                                            Invoice <i class="fa-solid fa-credit-card text-primary"></i>
                                        </h5>
                                        <button type="button" id="printInvoiceButton"
                                            onclick="printInvoice({{ $order->id }})"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-print"></i> Print Invoice
                                        </button>
                                    </div>
                                    <br>
                                    <h4 class="font-weight-bold">Grand Total (₱): {{ $order->grand_total . '.00' }}</h4>
                                    <h6>Order No. {{ $order->order_number }}</h6>
                                    <h6>Reference No. <span id="ref">{{ $order->reference_number }}</span></h6>
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
                                        <div class="col">
                                            <h6 class="text-center">Method: <span
                                                    class="badge badge-light">{{ $order->shipping_option }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                    @if (
                                        ($order->customer_type == 'online_shopper' || $order->customer_type == 'guest') &&
                                            $order->payment_method != 'Cash On Delivery')
                                        <br>
                                        <button type="button" class="btn btn-sm btn-info order-edit-btn"
                                            data-order-id="{{ $order->id }}">Edit</button>
                                        <br>
                                        <div class="d-grid gap-2 col-6 mx-auto">
                                            <button type="button" class="mx-auto text-center btn btn-sm btn-primary"
                                                data-bs-toggle="collapse" data-bs-target="#PaymentReciept"
                                                aria-expanded="false" aria-controls="PaymentReciept">View Payment
                                                Reciept</button>
                                        </div>
                                        <div class="collapse mt-3" id="PaymentReciept">
                                            <div class="card card-body">
                                                <a href="{{ asset('storage/' . $order->payment_receipt) }}"
                                                    data-fancybox="gallery" data-caption="Payment Reciept">
                                                    <img src="{{ asset('storage/' . $order->payment_receipt) }}"
                                                        class="img-fluid" alt="Image">
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-manage-order" role="tabpanel" aria-labelledby="pills-manage-order-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @switch($order->status)
                        @case('Pending')
                            <div class="col-md-7 d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <div class="">
                                            <h5 class="font-weight-bold text-primary">Manage Order *</h5>
                                        </div>
                                        <form class="form mb-3" method="POST"
                                            action="{{ route('admin.orders.approved', ['id' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-sm btn-primary"><i
                                                        class="fa-solid fa-thumbs-up me-1"></i> Approved</button>
                                            </div>
                                        </form>
                                        <div class="border-top mb-3"></div>
                                        <form class="form" method="POST"
                                            action="{{ route('admin.orders.reject', ['id' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="remarks" id="remarks"
                                                    placeholder="remarks" required>
                                                <label for="remarks">Remarks:</label>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa-solid fa-ban me-1"></i> Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-self-stretch">
                                <div class="d-grid text-center">
                                    <img src="{{ asset('images/manage_order.png') }}" class="img-fluid"
                                        alt="Manage Order Picture">
                                    <h5 class="font-weight-light">Order is waiting to be processed...</h5>
                                </div>
                            </div>
                        @break

                        @case('Approved')
                            <div class="col-md-7 d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <div class="">
                                            <h5 class="font-weight-bold text-primary">Manage Order *</h5>
                                        </div>
                                        @if ($order->shipping_option == 'Delivery')
                                            <form class="form" method="POST"
                                                action="{{ route('admin.orders.otw', ['id' => $order->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-sm btn-warning"><i
                                                            class="fa-solid fa-truck-fast me-1"></i> On The Way</button>
                                                </div>
                                            </form>
                                        @elseif ($order->shipping_option == 'Pick Up')
                                            <form class="form" method="POST"
                                                action="{{ route('admin.orders.pick_up', ['id' => $order->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-sm btn-warning"><i
                                                            class="fa-solid fa-box-archive me-1"></i> Read to Pick Up</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-self-stretch">
                                <div class="d-grid text-center">
                                    <img src="{{ asset('images/processing.png') }}" class="img-fluid"
                                        alt="Manage Order Picture">
                                    <h5 class="font-weight-light">Order is waiting to be deliver...</h5>
                                </div>
                            </div>
                        @break

                        @case('On The Way')
                            <div class="col-md-7 d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <div class="">
                                            <h5 class="font-weight-bold text-primary">Manage Order *</h5>
                                        </div>
                                        <form class="form" method="POST"
                                            action="{{ route('admin.orders.delivered', ['id' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-sm btn-success"><i
                                                        class="fa-solid fa-circle-check me-1"></i> Delivered</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-self-stretch">
                                <div class="d-grid text-center">
                                    <img src="{{ asset('images/on_the_way.png') }}" class="img-fluid"
                                        alt="Manage Order Picture">
                                    <h5 class="font-weight-light">Order is on the way!</h5>
                                </div>
                            </div>
                        @break

                        @case('Ready To Pick Up')
                            <div class="col-md-7 d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <div class="">
                                            <h5 class="font-weight-bold text-primary">Manage Order *</h5>
                                        </div>
                                        <form class="form" method="POST"
                                            action="{{ route('admin.orders.delivered', ['id' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-sm btn-success"><i
                                                        class="fa-solid fa-circle-check me-1"></i> Recieved</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-self-stretch">
                                <div class="d-grid text-center">
                                    <img src="{{ asset('images/ready_to_pick_up.png') }}" class="img-fluid"
                                        alt="Manage Order Picture">
                                    <h5 class="font-weight-light">Order is ready to pick up!</h5>
                                </div>
                            </div>
                        @break

                        @case('Rejected')
                            <div class="col d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <div class="d-grid text-center">
                                            <h5 class="mt-2 font-weight-light">Order has been rejected...</h5>
                                            <img src="{{ asset('images/rejected.png') }}" class="img-fluid mx-auto"
                                                alt="Manage Order Picture">
                                            <h5>Reasons: {{ $order->comments }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @break

                        @case('Delivered' || 'Recieved')
                            @php
                                if ($order->shipping_option == 'Delivery') {
                                    $message = 'Order has been delivered successfully!';
                                } elseif ($order->shipping_option == 'Pick Up') {
                                    $message = 'The customer has successfully picked up the order!';
                                }
                            @endphp
                            <div class="col d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <div class="d-grid text-center">
                                            <h5 class="mt-2 font-weight-light">{{ $message }}</h5>
                                            <img src="{{ asset('images/delivered.png') }}" class="img-fluid"
                                                alt="Manage Order Picture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @break

                        @default
                    @endswitch

                </div>
            </div>
        </div>

        <script>
            function printInvoice(id) {
                const printWindow = window.open(`{{ route('admin.orders.print-invoice', '') }}/${id}`, '_blank');

                const closePrintTab = function() {
                    printWindow.close();
                };

                printWindow.onload = function() {
                    printWindow.print();
                };

                // Listen for the beforeprint event
                window.addEventListener('beforeprint', closePrintTab);

                // Remove the event listener if the user cancels the print
                window.addEventListener('afterprint', function() {
                    window.removeEventListener('beforeprint', closePrintTab);
                });
            }
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

                $(document).on('click', '.order-edit-btn', function() {
                    var orderId = $('.order-edit-btn').data('order-id');

                    $.ajax({
                        url: "{{ route('admin.orders.fetch') }}", // Replace with the desired URL for updating a product
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            $('#editOrderId').val(orderId);
                            $('#editOrderRef').val(response.ref);

                            // Show the edit modal
                            $('#editOrderModal').modal('show');
                        },
                        error: function(error) {
                            console.error(error.responseJSON.message);
                        }
                    });


                });

                $('#editOrderForm').submit(function(e) {
                    e.preventDefault();

                    var orderId = $('#editOrderId').val();

                    // Perform the AJAX request to update the product and variant
                    $.ajax({
                        url: "{{ route('admin.orders.ref') }}", // Replace with the desired URL for updating a product
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            ref: $('#editOrderRef').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Close the edit modal
                            $('#editOrderModal').modal('hide');

                            // Show success notification
                            showNotification('info', 'Order Reference Updated',
                                'The reference number of the order has been successfully updated '
                            );

                            $('#ref').text(response.ref);

                        },
                        error: function(error) {
                            console.error(error.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    @endif
@endsection
