@extends('layouts.admin')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">All Products</a></li>
            <li class="breadcrumb-item ">{{ $product->variant->name }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="container-fluid mt-2">
        <div class="row w-100 justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset($product->img) }}" class="img-fluid" alt="product picture">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $product->name }}</h3>
                        <h5>Variant: {{ $product->variant->name }}</h5>
                        <h5>{{ '₱' . $product->price . '.00' }}</h5>
                        <br>
                        <h5>{{ $product->stocks }} Items left</h5>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded shadow-sm p-4">
            <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Validation Error:</strong>
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <img src="{{ asset($product->img) }}" alt="{{ $product->name }}" class="w-64 h-64 object-cover rounded">
            </div>

            <div class="mb-4">
                <strong>Variant:</strong> {{ $product->variant }}
            </div>

            <div class="mb-4">
                <strong>Price:</strong> ${{ $product->price }}
            </div>

            <h2 class="text-lg font-bold mb-2">Product Stock</h2>

            @if ($product->stocks->isEmpty())
                <p>No stock available.</p>
            @else
                <div class="mb-4">
                    <canvas id="productStockChart" width="400" height="200"></canvas>
                </div>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Stock</th>
                            <th class="px-4 py-2">Date Created</th>
                            <th class="px-4 py-2">Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->stocks as $stock)
                            <tr>
                                <td class="border px-4 py-2">{{ $stock->stock }}</td>
                                <td class="border px-4 py-2">{{ $stock->date_created }}</td>
                                <td class="border px-4 py-2">{{ $stock->expiration_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('admin.products.edit', $product) }}"
                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>

            <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700">Back</a>
        </div>
    </div> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        $(document).ready(function() {

        });
    </script>
    {{-- <script>
        // Generate pie chart for product stock
        var ctx = document.getElementById('productStockChart').getContext('2d');
        var productStockChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($product->stocks->pluck('date_created')->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($product->stocks->pluck('stock')->toArray()) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                }],
            },
            options: {
                responsive: true,
            }
        });

    </script> --}}
@endsection
