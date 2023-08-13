@extends('layouts.client')
@section('content')
    <div class="text-center text-dark fw-bolder mt-3">
        <p class="fs-2">SELECT YOUR LOCATION</p>
    </div>
    <form method="POST" action="{{ route('location.confirm', ['backRoute' => Route::currentRouteName()]) }}" class="container py-5 mb-5">
        @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <select class="form-select" id="regionSelect" name="region" aria-label="select region">
                        <option disabled selected value="">Select your region</option>
                    </select>
                    <label for="payment_method">Region *</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="provinceSelect" name="province" aria-label="select province">
                        <option disabled selected value="">Select your province</option>
                    </select>
                    <label for="provinceSelect">Province *</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="municipalitySelect" name="municipality"
                        aria-label="select municipality">
                        <option disabled selected value="">Select your municipality</option>
                    </select>
                    <label for="municipalitySelect">Municipality *</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="barangaySelect" name="barangay" aria-label="select barangay">
                        <option disabled selected value="">Select your barangay</option>
                    </select>
                    <label for="barangaySelect">Barangay *</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="street" id="street" placeholder="enter street">
                    <label for="street">Street Name, Building, House No. *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="zip_code" id="zip_code" placeholder="enter zip_code">
                    <label for="zip_code">Zip Code *</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="label" name="label" aria-label="select label">
                        <option value="home">home</option>
                        <option value="office">office</option>
                    </select>
                    <label for="label">Label As *</label>
                </div>
            </div>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
    <script src="{{ asset('js/load_address.js') }}"></script>
@endsection
