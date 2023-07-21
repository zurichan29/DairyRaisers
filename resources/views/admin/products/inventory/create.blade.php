@extends('layouts.admin')

@section('content')

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded shadow-sm p-4">
            <h1 class="text-2xl font-bold mb-4">Create Product</h1>

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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="form-input rounded-md border-gray-300 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="img" class="block text-gray-700 font-semibold mb-2">Image</label>
                    <input type="file" name="img" id="img"
                        class="form-input rounded-md border-gray-300 @error('img') border-red-500 @enderror" required>
                    @error('img')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">

                    <label for="variant" class="block text-gray-700 font-semibold mb-2">Variant</label>
                    <select name="variant" id="variant">
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->name }}">{{ $variant->name }}</option>
                        @endforeach
                    </select>
                    @error('variant')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                        class="form-input rounded-md border-gray-300 @error('price') border-red-500 @enderror"
                        step="0.01" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create
                        Product</button>
                </div>

                <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700">Back</a>
            </form>
        </div>
    </div>
@endsection