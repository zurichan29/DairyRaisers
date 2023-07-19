@extends('layouts.client')
@section('content')
    <form method="POST" action="{{ URL::secure(route('checkout.edit_address.validate', ['id' => $address['id']])) }}" id="addressForm">
        @csrf
        <select id="regionSelect" name="region" required>
            <option disabled value="">Select your region</option>
            @foreach ($regions as $regionCode => $regionData)
                <option value="{{ $regionCode }}" {{ $address->region === $regionData['region_name'] ? 'selected' : '' }}>
                    {{ $regionData['region_name'] }}
                </option>
            @endforeach
        </select>

        <select id="provinceSelect" name="province" required>
            <option disabled value="">Select your province</option>
            @foreach ($addressData as $regionCode => $regionData)
                @if ($regionData['region_name'] === $address->region)
                    @foreach ($regionData['province_list'] as $provinceName => $provinceData)
                        <option value="{{ $provinceName }}" {{ $address->province === $provinceName ? 'selected' : '' }}>
                            {{ $provinceName }}
                        </option>
                    @endforeach
                @endif
            @endforeach
        </select>

        <select id="municipalitySelect" name="municipality" required>
            <option disabled value="">Select your municipality</option>
            @foreach ($addressData as $regionCode => $regionData)
                @if ($regionData['region_name'] === $address->region)
                    @foreach ($regionData['province_list'][$address->province]['municipality_list'] as $municipalityName => $municipalityData)
                        <option value="{{ $municipalityName }}"
                            {{ $address->municipality === $municipalityName ? 'selected' : '' }}>
                            {{ $municipalityName }}
                        </option>
                    @endforeach
                @endif
            @endforeach
        </select>

        <select id="barangaySelect" name="barangay" required>
            <option disabled value="">Select your barangay</option>
            @foreach ($addressData as $regionCode => $regionData)
                @if ($regionData['region_name'] === $address->region)
                    @foreach ($regionData['province_list'][$address->province]['municipality_list'][$address->municipality]['barangay_list'] as $barangay)
                        <option value="{{ $barangay }}" {{ $address->barangay === $barangay ? 'selected' : '' }}>
                            {{ $barangay }}
                        </option>
                    @endforeach
                @endif
            @endforeach
        </select>

        <label for="street">Street Name, Building, House No.</label>
        <input type="string" name="street" id="street" value="{{ $address->street }}" required>
        <label for="zip_code">Zip Code:</label>
        <input type="number" name="zip_code" id="zip_code" value="{{ $address->zip_code }}" required>
        <select name="label" id="label">
            <option value="home" {{ $address->label === 'home' ? 'selected' : '' }}>home</option>
            <option value="office" {{ $address->label === 'office' ? 'selected' : '' }}>office</option>
        </select>
        {{-- <label for="street">Street:</label>
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
        @enderror --}}

        <button type="submit">Submit</button>
    </form>
@endsection
