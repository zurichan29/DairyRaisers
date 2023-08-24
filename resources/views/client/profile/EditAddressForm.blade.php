@extends('layouts.client')
@section('content')
    <div class="text-center text-dark fw-bolder mb-3">
        <p class="fs-2">UPDATE YOUR LOCATION</p>
    </div>
    <form method="POST" action="{{ route('address.update', ['id' => $address->id]) }}" class="container mb-3">
        @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <select class="form-select" id="municipalitySelect" name="municipality" aria-label="select municipality">
                        <option disabled selected value="">Select your municipality</option>
                        @foreach ($addressData['4A']['province_list']['CAVITE']['municipality_list'] as $municipalityName => $municipalityData)
                            <option value="{{ $municipalityName }}"
                                {{ $address['municipality'] == $municipalityName ? 'selected' : '' }}>
                                {{ $municipalityName }}
                            </option>
                        @endforeach
                    </select>
                    <label for="municipalitySelect">Municipality *</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="barangaySelect" name="barangay" aria-label="select barangay">
                        <option disabled selected value="">Select your barangay</option>
                        @foreach ($addressData['4A']['province_list']['CAVITE']['municipality_list'][$address['municipality']]['barangay_list'] as $barangay)
                            <option value="{{ $barangay }}" {{ $address['barangay'] === $barangay ? 'selected' : '' }}>
                                {{ $barangay }}
                            </option>
                        @endforeach
                    </select>
                    <label for="barangaySelect">Barangay *</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="street" id="street"
                        value="{{ $address['street'] }}" placeholder="enter street">
                    <label for="street" class="custom-floating-label">Street Name, Building, House No. *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="zip_code" id="zip_code"
                        value="{{ $address['zip_code'] }}" placeholder="enter zip_code">
                    <label for="zip_code" class="custom-floating-label">Zip Code *</label>
                </div>
            </div>

        </div>


        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
    {{-- <script src="{{ asset('js/load_address.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $.getJSON('/js/philippine_address_2019v2.json')
                .done(function(data) {
                    var municipalityList = data['4A'].province_list['CAVITE'].municipality_list;
                    var municipalities = Object.keys(municipalityList).map(function(municipalityName) {
                        return {
                            code: municipalityName,
                            name: municipalityName
                        };
                    });

                    populateSelectOptions('#municipalitySelect', municipalities, 'Select your municipality');

                    // Pre-select municipality
                    var selectedMunicipality = '{{ $address['municipality'] }}';
                    $('#municipalitySelect').val(selectedMunicipality).trigger(
                        'change'); // Trigger change event
                })
                .fail(function() {
                    console.error('Failed to load address data.');
                });

            $('#municipalitySelect').on('change', function() {
                var municipalityName = $(this).val();
                if (municipalityName) {
                    $.getJSON('/js/philippine_address_2019v2.json')
                        .done(function(data) {
                            var barangayList = data['4A'].province_list['CAVITE'].municipality_list[
                                municipalityName].barangay_list;
                            var barangays = barangayList.map(function(barangayName) {
                                return {
                                    code: barangayName,
                                    name: barangayName
                                };
                            });

                            populateSelectOptions('#barangaySelect', barangays, 'Select your barangay');

                            // Pre-select barangay
                            var selectedBarangay = '{{ $address['barangay'] }}';
                            $('#barangaySelect').val(selectedBarangay);
                        })
                        .fail(function() {
                            console.error('Failed to load address data.');
                        });
                } else {
                    $('#barangaySelect').empty().append($(
                        '<option disabled selected value="">Select your barangay</option>').text(
                        'Select your barangay'));
                }
            });

            function populateSelectOptions(selectId, options, placeholder) {
                var select = $(selectId);
                select.empty();
                select.append($('<option disabled selected value="">' + placeholder + '</option>').text(
                    placeholder)); // Add placeholder option
                $.each(options, function(index, option) {
                    select.append($('<option></option>').val(option.code).text(option.name));
                });
            }
        });
    </script>
@endsection
