@extends('layouts.admin')

@section('content')

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Add Milks</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="POST" action="{{ route('admin.buffalos.store') }}">
                @csrf
                <div class="form-floating mb-3">
                    <div>
                    <label for="date_created">Date Produced</label>
                    </div>
                    <input type="date" class="form-control" name="date_created" id="date_created"
                        placeholder="Date Created">
                    <span id="dateCreatedSelected"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="quantity" id="quantity"
                        placeholder="Quantity">
                    <label for="quantity">Quantity</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
