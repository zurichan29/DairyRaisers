@extends('layouts.client')
@section('content')
    <form method="POST" action="{{ URL::secure(route('checkout.edit_address.validate', ['id' => $address->id])) }}">
        @csrf
        <label for="street">Street:</label>
        <input type="text" name="street" id="street" value="{{ old('street') ?? $address->street }}" required>
        @error('street')
            <p>{{ $message }}</p>
        @enderror

        <label for="barangay">Barangay:</label>
        <input type="text" name="barangay" id="barangay" value="{{ old('barangay') ?? $address->barangay }}" required>
        @error('barangay')
            <p>{{ $message }}</p>
        @enderror

        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="{{ old('city') ?? $address->city }}"
        required>
        @error('city')
            <p>{{ $message }}</p>
        @enderror

        <label for="province">Province:</label>
        <input type="text" name="province" id="province" value="{{ old('province') ?? $address->province }}"
        required>
        @error('province')
            <p>{{ $message }}</p>
        @enderror

        <label for="zip_code">Zip Code:</label>
        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') ?? $address->zip_code }}"
        required>
        @error('zip_code')
            <p>{{ $message }}</p>
        @enderror

        <label for="label">label As:</label>
        <input type="text" name="label" id="label" value="{{ old('label') ?? $address->label }}"
        required>
        @error('label')
            <p>{{ $message }}</p>
        @enderror

        <label for="remarks">Remarks:</label>
        <input type="text" name="remarks" id="remarks" value="{{ old('remarks') ?? $address->remarks }}"
        required>
        @error('remarks')
            <p>{{ $message }}</p>
        @enderror

        <button type="submit">Submit</button>
    </form>

@endsection
