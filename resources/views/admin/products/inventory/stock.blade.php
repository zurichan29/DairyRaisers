@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded shadow-sm p-4">
        <h1 class="text-2xl font-bold mb-4">Add Stock</h1>
        <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
        <div class="mb-4">
            <img src="{{ asset($product->img) }}" alt="{{ $product->name }}" class="w-64 h-64 object-cover rounded">
        </div>
        <p class="mb-2">Variant: {{ $product->variant }}</p>
        <p class="mb-2">Total quantity: {{ $totalStock }}</p>
        <p class="mb-2">{{ now() }}</p>

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

        <form action="{{ route('admin.products.stock.store', ['product' => $product->id ]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="stock" class="block text-gray-700 font-semibold mb-2">Input quantity</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                    class="form-input rounded-md border-gray-300 @error('stock') border-red-500 @enderror" required>
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add
                    Stock</button>
            </div>

            <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700">Back</a>
        </form>
    </div>
</div>
@endsection
