@extends('layouts.admin')

@section('content')
     <!-- Page Heading -->
     <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Inventory</h1>
    </div>

    <div class="card shadow mb-4">
        <p>{{ now()->format('Y-m-d') }}</p>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th class="">Name</th>
                    <th class="">Variant</th>
                    <th class="">Price</th>
                    <th class="">Qty</th>
                    <th class=""></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->variant }}</td>
                        <td class="border px-4 py-2">{{ $product->price }}</td>
                        <td class="border px-4 py-2">{{ $product->product_stocks_sum_stock }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.products.show', $product) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">View</a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                            <a href="{{ route('admin.products.stock', $product) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Add Stock</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
