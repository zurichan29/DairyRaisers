@extends('layouts.client')
@section('content')

    <form action="{{ route('update.address', ['id' => $address['id']]) }}" method="POST" id="addressForm">
        @csrf
        @method('PUT')
        <select id="regionSelect" name="region" required>
            <option disabled value="">Select your region</option>
            @foreach ($regions as $regionCode => $regionData)
                <option value="{{ $regionCode }}"
                    {{ $address->region === $regionData['region_name'] ? 'selected' : '' }}>
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
        
        <button type="submit">Update Address</button>
    </form>

@endsection
