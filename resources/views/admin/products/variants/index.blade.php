@extends('layouts.admin')

@section('content')
    <h1>Variants</h1>
    <form action="{{ route('admin.products.variants.store') }}" method="POST">
        @csrf
        <label for="">Name</label>
        <input type="text" name="name" required>
        @error('name')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">Create</button>
    </form>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($variants as $variant)
                <tr>
                    <td class="border px-4 py-2">{{ $variant->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
