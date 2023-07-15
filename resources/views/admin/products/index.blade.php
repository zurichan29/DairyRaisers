@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded shadow-sm p-4">
        <h1 class="text-2xl font-bold mb-4">Inventory</h1>

        <a href="{{ route('admin.products.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
            Add Product
        </a>

        <p>{{ now()->format('Y-m-d') }}</p>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 py-2 px-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Variant</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Qty</th>
                    <th class="px-4 py-2">Actions</th>
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
