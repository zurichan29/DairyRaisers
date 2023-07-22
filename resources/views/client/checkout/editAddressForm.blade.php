@extends('layouts.client')
@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Go back</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit default Address</li>
        </ol>
    </nav>
    <form method="POST" action="{{ URL::secure(route('checkout.edit.address.validate', ['id' => $address['id'], 'prev' => $prev])) }}"
        id="addressForm" class="w-100 mb-5">
        @csrf
        <div class="form-floating mb-3">
            <select class="form-select" id="regionSelect" name="region" aria-label="select region">
                <option disabled selected value="">Select your region</option>
                @foreach ($regions as $regionCode => $regionData)
                    <option value="{{ $regionCode }}"
                        {{ $address->region === $regionData['region_name'] ? 'selected' : '' }}>
                        {{ $regionData['region_name'] }}
                    </option>
                @endforeach
            </select>
            <label for="payment_method">Region *</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="provinceSelect" name="province" aria-label="select province">
                <option disabled selected value="">Select your province</option>
                @foreach ($addressData as $regionCode => $regionData)
                    @if ($regionData['region_name'] === $address->region)
                        @foreach ($regionData['province_list'] as $provinceName => $provinceData)
                            <option value="{{ $provinceName }}"
                                {{ $address->province === $provinceName ? 'selected' : '' }}>
                                {{ $provinceName }}
                            </option>
                        @endforeach
                    @endif
                @endforeach
            </select>
            <label for="provinceSelect">Province *</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="municipalitySelect" name="municipality" aria-label="select municipality">
                <option disabled selected value="">Select your municipality</option>
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
            <label for="municipalitySelect">Municipality *</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="barangaySelect" name="barangay" aria-label="select barangay">
                <option disabled selected value="">Select your barangay</option>
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
            <label for="barangaySelect">Barangay *</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="street" id="street" value="{{ $address->street }}"
                placeholder="enter street">
            <label for="street">Street Name, Building, House No. *</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="zip_code" id="zip_code" value="{{ $address->zip_code }}"
                placeholder="enter zip_code">
            <label for="zip_code">Zip Code *</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="label" name="label" id="label" aria-label="select label">
                <option value="home" {{ $address->label === 'home' ? 'selected' : '' }}>home</option>
                <option value="office" {{ $address->label === 'office' ? 'selected' : '' }}>office</option>
            </select>
            <label for="label">Label As *</label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
