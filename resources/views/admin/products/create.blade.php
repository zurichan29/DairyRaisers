@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Add Product</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="img" id="img" class="w-full px-4 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="variant" class="block text-sm font-medium text-gray-700 mb-2">Variant</label>
                <input type="text" name="variant" id="variant" class="w-full px-4 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <input type="number" name="price" id="price" class="w-full px-4 py-2 border rounded" step="0.01"
                    required>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Product
                </button>
            </div>
        </form>
    </div>
@endsection
