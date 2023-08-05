@extends('layouts.admin')
@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <style>
            #dataTable {
                font-size: 14px
            }
        </style>
       

        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h1 class="h3 text-primary">Orders</h1>
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    <span class="text">
                        New Order
                    </span>
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ORDER NO.</th>
                                <th>TYPE</th>
                                <th>CUSTOMER</th>
                                <th>MOBILE NO.</th>
                                <th>METHOD</th>
                                <th>GRAND TOTAL</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ORDER NO.</th>
                                <th>TYPE</th>
                                <th>CUSTOMER</th>
                                <th>MOBILE NO.</th>
                                <th>METHOD</th>
                                <th>GRAND TOTAL</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($orders as $order)
                                @php
                                    $statusBadge = null;
                                    $icon = null;
                                    switch ($order->status) {
                                        case 'Pending':
                                            $statusBadge = 'badge-info';
                                            $icon = 'fa-solid fa-spinner me-1';
                                            break;
                                        case 'Approved':
                                            $statusBadge = 'badge-primary';
                                            $icon = 'fa-solid fa-thumbs-up me-1';
                                            break;
                                        case 'On The Way':
                                            $statusBadge = 'badge-warning';
                                            $icon = 'fa-solid fa-truck-fast me-1';
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
                                @endphp
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <!-- Display customer details based on their type -->
                                    @if ($order->customer instanceof \App\Models\OnlineShopper)
                                        @if ($order->customer->user)
                                            <td>Online Shopper</td>
                                            <td>{{ $order->customer->user->first_name . ' ' . $order->customer->user->last_name }}
                                            </td>
                                            <td>{{ $order->customer->user->mobile_number }}</td>
                                        @endif
                                        <!-- Display other online shopper-specific details -->
                                    @elseif ($order->customer instanceof \App\Models\Retailer)
                                        <td>Retailer</td>
                                        <td>{{ $order->customer->first_name . ' | ' . $order->customer->store_name }}</td>
                                        <td>{{ $order->customer->mobile_number }}</td>
                                        <!-- Display other retailer-specific details -->
                                    @endif

                                    {{-- <td>{{ $order->reference_number }}</td> --}}
                                    <td>{{ $order->shipping_option }}</td>
                                    <td>{{ $order->grand_total }}</td>
                                    <td class=" text-center">
                                        <p class="badge {{ $statusBadge }} text-center text-wrap py-2"
                                            style="width: 8rem;">
                                            <i class="{{ $icon }}"></i>
                                            {{ $order->status }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.orders.show', ['id' => $order->id]) }}">View</a>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <script>
        function fetchNotifications() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                }
            });
            $.ajax({
                url: "{{ route('fetch-notifications') }}", // Replace with the URL that returns the user's notifications
                method: 'GET',
                processData: false,
                contentType: false,
                success: function(notifications) {
                    // Handle the response and update the UI with new notifications
                    // You can show the notifications in a popup or update the notification panel
                    console.log(notifications);
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.log(xhr);
                }
            });
        }

        // Call the fetchNotifications function every few seconds
        setInterval(fetchNotifications, 5000); // Fetch notifications every 5 seconds (adjust the interval as needed)
    </script> --}}

        <script>
            $(document).ready(function() {

                var dataTable = $('#dataTable').DataTable({
                   
                });

                $('#statusFilter').on('change', function() {
                    var status = $(this).val();
                    dataTable.column(3).search(status).draw();
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


            });
        </script>
        <script src="{{ asset('js/load_address.js') }}"></script>
        <script src="{{ asset('js/validate_address.js') }}"></script>
    @endif
@endsection
