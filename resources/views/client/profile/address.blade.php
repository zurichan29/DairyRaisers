@extends('layouts.client')
@section('content')

    <div style="max-width: 350px; min-height: 400px; margin: 80px auto; padding: 30px 30px 30px 30px;
        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">

        @if ($addresses)
            @foreach ($addresses as $address)
                <h1 style="font-size: 1rem;">Region: {{ $address['region'] }}</h1>
                <h1 style="font-size: 1rem;">Province: {{ $address['province'] }}</h1>
                <h1 style="font-size: 1rem;">Municipality: {{ $address['municipality'] }}</h1>
                <h1 style="font-size: 1rem;">Barangay: {{ $address['barangay'] }}</h1>
                <h1 style="font-size: 1rem;">Street: {{ $address['street'] }}</h1>
                <h1 style="font-size: 1rem;">Label: {{ $address['label'] }}</h1>
                <h1 style="font-size: 1rem;">Zip Code: {{ $address['zip_code'] }}</h1>
                <h1 style="font-size: 1rem;">Default: {{ $address['default'] }}</h1>
                <a href="{{ URL::secure(route('edit.address', ['id' => $address['id']])) }}">Edit Address</a>
                @if ($address['default'] != 1)
                    <form action="{{ route('default.address', ['id' => $address['id']]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-2" style="width:100%; height: 40px; border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                            Make Default
                        </button>
                    </form>
                @endif
                <form action="{{ URL::secure(route('delete.address', ['id' => $address['id']])) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary mt-4" style="width:100%; height: 40px; background-color:rgb(248, 53, 53); border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                        Delete Address
                    </button>
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
    </div>
    <div style="max-width: 350px; min-height: 400px; margin: 80px auto; padding: 30px 30px 30px 30px;
        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
        <form action="{{ route('create.address') }}" method="POST" id="addressForm">
            @csrf
            <select id="regionSelect" name="region" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
                <option disabled selected value="">Select your region</option>
            </select>
            <select id="provinceSelect" name="province" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
                <option disabled selected value="">Select your province</option>
            </select>
            <select id="municipalitySelect" name="municipality" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
                <option disabled selected value="">Select your municipality</option>
            </select>
            <select id="barangaySelect" name="barangay" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
                <option disabled selected value="">Select your barangay</option>
            </select>
            <label for="street">Street Name, Building, House No.</label>
            <input type="string" name="street" id="street" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            <label for="zip_code">Zip Code:</label>
            <input type="number" name="zip_code" id="zip_code" style="width: 100%; border: none; outline: none; background: none; font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px; box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            <select name="label" id="label" style=" border: none; outline: none; background: none; font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px; box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">
                <option value="home">Home</option>
                <option value="office">Office</option>
            </select>
            <button type="submit" class="btn btn-primary" style="width: 100%; height: 40px; border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                Create Address
            </button>
        </form>
    </div>

@endsection
