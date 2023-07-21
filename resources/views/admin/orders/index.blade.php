@extends('layouts.admin')
@section('content')
    <!-- Page Heading -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Orders</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="m-3">
            <label class="visually-hidden" for="statusFilter">Preference</label>
            <select class="form-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="Pending">Pending Status</option>
                <option value="Delivery">Delivery Status</option>
                <option value="Pick-up">Pick-up Status</option>
                <option value="Rejected">Rejected Status</option>
            </select>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Reference No.</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Order No.</th>
                            <th>Reference No.</th>
                            <th>Customer</th>
                            <th>Status</th>
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
                                    case 'Delivered':
                                        $statusBadge = 'badge-success';
                                        $icon = 'fa-solid fa-circle-check me-1';
                                        break;
                                    default:
                                        break;
                                }
                            @endphp
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->reference_number }}</td>
                                <td>{{ $order->user->first_name . ' ' . $order->user->last_name }}</td>
                                <td class=" text-center">
                                    <p class="badge {{ $statusBadge }} text-center text-wrap py-2" style="width: 8rem;">
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
                                                href="{{ route('admin.orders.show', ['id' => $order->id]) }}">view</a>
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


    <script>
        $(document).ready(function() {
            var dataTable = $('#dataTable').DataTable();
            $('#statusFilter').on('change', function() {
                var status = $(this).val();
                dataTable.column(3).search(status).draw();
            });
        });
    </script>
@endsection
