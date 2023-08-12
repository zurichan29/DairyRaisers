<div class="col" id="addressForm">
    {{-- <div class="row mb-3">
        <h4 class="text-primary">CONTACT INFORMATION</h4>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="first_name"
            value="{{ auth()->check() && $user->first_name ? $user->first_name : old('first_name') }}" id="first_name"
            placeholder="enter First Name">
        <label for="first_name">First Name *</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="last_name"
            value="{{ auth()->check() && $user->last_name ? $user->last_name : old('last_name') }}" id="last_name"
            placeholder="enter Last Name">
        <label for="last_name">Last Name *</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" name="mobile_number"
            value="{{ auth()->check() && $user->mobile_number ? $user->mobile_number : old('mobile_number') }}"
            id="mobile_number" placeholder="enter Last Name">
        <label for="mobile_number">Mobile No. *</label>
    </div>
    <div class="border-top my-4"></div> --}}
  
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
        <select class="form-select" id="municipalitySelect" name="municipality" aria-label="select municipality">
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
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="street" id="street"
            placeholder="enter street">
        <label for="street">Street Name, Building, House No. *</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" name="zip_code" id="zip_code"
            placeholder="enter zip_code">
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