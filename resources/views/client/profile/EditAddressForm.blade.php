@extends('layouts.client')
@section('content')

    <div style="max-width: 350px; min-height: 400px; margin: 80px auto; padding: 30px 30px 30px 30px;
        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">

        <form action="{{ route('update.address', ['id' => $address['id']]) }}" method="POST" id="addressForm">
            @csrf
            @method('PUT')
            <select id="regionSelect" name="region" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
                <option disabled value="">Select your region</option>
                @foreach ($regions as $regionCode => $regionData)
                    <option value="{{ $regionCode }}"
                        {{ $address->region === $regionData['region_name'] ? 'selected' : '' }}>
                        {{ $regionData['region_name'] }}
                    </option>
                @endforeach
            </select>

            <select id="provinceSelect" name="province" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
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

            <select id="municipalitySelect" name="municipality" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
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

            <select id="barangaySelect" name="barangay" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
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
            <input type="string" name="street" id="street" value="{{ $address->street }}" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            <label for="zip_code">Zip Code:</label>
            <input type="number" name="zip_code" id="zip_code" value="{{ $address->zip_code }}" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;" required>
            <select name="label" id="label" style="width: 100%; border: none; outline: none; background: none;
            font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">
                <option value="home" {{ $address->label === 'home' ? 'selected' : '' }}>Home</option>
                <option value="office" {{ $address->label === 'office' ? 'selected' : '' }}>Office</option>
            </select>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; height: 40px; border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                Update Address
            </button>
        </form>

    </div>
@endsection
