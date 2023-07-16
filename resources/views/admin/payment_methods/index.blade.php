@extends('layouts.admin')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Payment Methods</h1>
        <a href="#" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
            <span class="text">
                Create Payment Method
            </span>
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Account Name</th>
                            <th>Account No.</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Type</th>
                            <th>Account Name</th>
                            <th>Account No.</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($payment_methods as $method)
                            <tr>
                                <td>{{ $method->type }}</td>
                                <td>{{ $method->account_name }}</td>
                                <td>{{ $method->account_number }}</td>
                                <td>{{ $method->status }}</td>
                                <td>Action button</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
