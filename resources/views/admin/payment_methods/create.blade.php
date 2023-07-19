@extends('layouts.admin')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.payment_method.index') }}">Payment Methods</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Create new Payment Method</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="POST" action="{{ route('admin.payment_method.store') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="type" id="type" placeholder="Type">
                    <label for="type">Type</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="account_name" id="account_name"
                        placeholder="Account Name">
                    <label for="account_name">Account Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="account_number" id="account_number"
                        placeholder="Account Number">
                    <label for="account_number">Account Number</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
