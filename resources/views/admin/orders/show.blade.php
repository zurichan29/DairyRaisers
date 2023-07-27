@extends('layouts.admin')
@section('content')
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
                            <input type="text" class="form-control" name="ref" id="editOrderRef" placeholder="ref">
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
                                <h6>Referenace No. <span id="ref">{{ $order->reference_number }}</span></h6>
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
                                                class="badge badge-light">{{ $order->delivery_option }}</span>
                                        </h6>
                                    </div>
                                </div>
                                <br>
                                <button type="button" class="btn btn-sm btn-info order-edit-btn"
                                    data-order-id="{{ $order->id }}">Edit</button>
                                <br>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button type="button" class="mx-auto text-center btn btn-sm btn-primary"
                                        data-bs-toggle="collapse" data-bs-target="#PaymentReciept" aria-expanded="false"
                                        aria-controls="PaymentReciept">View Payment Reciept</button>
                                </div>
                                <div class="collapse mt-3" id="PaymentReciept">
                                    <div class="card card-body">
                                        <a href="{{ asset('storage/' . $order->payment_reciept) }}"
                                            data-fancybox="gallery" data-caption="Payment Reciept">
                                            <img src="{{ asset('storage/' . $order->payment_reciept) }}"
                                                class="img-fluid" alt="Image">
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
                                <img src="{{ asset('images/manage_order.png') }}" class="img-fluid" alt="Manage Order Picture">
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
                                    @if ($order->delivery_option == 'Delivery')
                                        <form class="form" method="POST"
                                            action="{{ route('admin.orders.otw', ['id' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-sm btn-warning"><i
                                                        class="fa-solid fa-truck-fast me-1"></i> On The Way</button>
                                            </div>
                                        </form>
                                    @elseif ($order->delivery_option == 'Pick Up')
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
                                <img src="{{ asset('images/processing.png') }}" class="img-fluid" alt="Manage Order Picture">
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
                                <img src="{{ asset('images/on_the_way.png') }}" class="img-fluid" alt="Manage Order Picture">
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
                                        <img src="{{ asset('images/rejected.png') }}" class="img-fluid"
                                            alt="Manage Order Picture">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @break

                    @case('Delivered' || 'Recieved')
                        @php
                            if ($order->delivery_option == 'Delivery') {
                                $message = 'Order has been delivered successfully!';
                            } elseif ($order->delivery_option == 'Pick Up') {
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

            function showNotification(status, message, productName) {
                var notification = $('#Notification');
                var notificationHeader = notification.find('.toast-header');
                var notificationBody = notification.find('.toast-body');
                var iconClass = '';
                var headerClass = '';
                var headerText = '';

                // Update classes, icon, and header text based on the status
                switch (status) {
                    case 'success':
                        headerClass = 'bg-success';
                        iconClass = 'fa-solid fa-circle-check';
                        headerText = 'Success';
                        break;
                    case 'updated':
                        headerClass = 'bg-info';
                        iconClass = 'fa-solid fa-circle-info';
                        headerText = 'Updated';
                        break;
                    case 'deleted':
                        headerClass = 'bg-warning';
                        iconClass = 'fa-solid fa-trash';
                        headerText = 'Deleted';
                        break;
                    case 'error':
                        headerClass = 'bg-danger';
                        iconClass = 'fa-solid fa-circle-xmark';
                        headerText = 'Error';
                        break;
                    default:
                        break;
                }

                // Update the notification content and classes
                notificationHeader.find('strong').removeClass().addClass('me-auto').html(
                    '<i class="me-2 fa-solid ' + iconClass + '"></i> ' + headerText);
                notification.find('.toast-header').removeClass().addClass('toast-header text-white').addClass(
                    headerClass);
                notificationBody.text(message);

                // Show the notification with fade-in and fade-out animations
                notification.toast({
                    animation: true
                });

                // Show the notification
                notification.toast('show');
            }

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
                        showNotification('updated', 'Order: ' + response.order_number +
                            ' updated successfully.');

                        $('#ref').text(response.ref);

                    },
                    error: function(error) {
                        console.error(error.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
