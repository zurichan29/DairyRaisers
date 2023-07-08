@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
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

            <a href="{{ route('admin.products.edit', $product) }}"
                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
        </div>
    </div>
@endsection
