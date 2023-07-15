@extends('layouts.client')
@section('content')
    @include('client.components.header')

    @if ($addresses)
        @foreach ($addresses as $address)
            <h1>Region: {{ $address['region'] }}</h1>
            <h1>Province: {{ $address['province'] }}</h1>
            <h1>Municipality: {{ $address['municipality'] }}</h1>
            <h1>Barangay: {{ $address['barangay'] }}</h1>
            <h1>Street: {{ $address['street'] }}</h1>
            <h1>Label: {{ $address['label'] }}</h1>
            <h1>Zip Code: {{ $address['zip_code'] }}</h1>
            <h1>Default: {{ $address['default'] }}</h1>
            <a href="{{ URL::secure(route('edit.address', ['id' => $address['id']])) }}">Edit Address</a>
            @if ($address['default'] != 1)
                <form action="{{ route('default.address', ['id' => $address['id']]) }}" method="post">
                    @csrf
                    <button type="submit">Make Default</button>
                </form>
            @endif
            <form action="{{ URL::secure(route('delete.address', ['id' => $address['id']])) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete Address</button>
            </form>
            
            {{-- <a href="{{ URL::secure(route('delete.address', ['id' => $address['id']])) }}">Delete Address</a> --}}
            <br><br>
        @endforeach
    @else
        <h1>NO ADDRESS FOUND</h1>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('create.address') }}" method="POST" id="addressForm">
        @csrf
        <select id="regionSelect" name="region" required>
            <option disabled selected value="">Select your region</option>
        </select>
        <select id="provinceSelect" name="province" required>
            <option disabled selected value="">Select your province</option>
        </select>
        <select id="municipalitySelect" name="municipality" required>
            <option disabled selected value="">Select your municipality</option>
        </select>
        <select id="barangaySelect" name="barangay" required>
            <option disabled selected value="">Select your barangay</option>
        </select>
        <label for="street">Street Name, Building, House No.</label>
        <input type="string" name="street" id="street" required>
        <label for="zip_code">Zip Code:</label>
        <input type="number" name="zip_code" id="zip_code" required>
        <select name="label" id="label">
            <option value="home">home</option>
            <option value="office">office</option>
        </select>
        <button type="submit">create address</button>
    </form>
    
    @include('client.components.footer')
@endsection
