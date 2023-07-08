@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded"
                    value="{{ $product->name }}" required>
            </div>

            <div class="mb-4">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="img" id="img" class="w-full px-4 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="variant" class="block text-sm font-medium text-gray-700 mb-2">Variant</label>
                <input type="text" name="variant" id="variant" class="w-full px-4 py-2 border rounded"
                    value="{{ $product->variant }}" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <input type="number" name="price" id="price" class="w-full px-4 py-2 border rounded" step="0.01"
                    value="{{ $product->price }}" required>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700text-white font-bold py-2 px-4 rounded">
                    Update Product
                </button>
            </div>
        </form>
    </div>
@endsection
