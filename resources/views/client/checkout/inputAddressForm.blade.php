<div class="border-r-[.1rem] border-solid border-[#136d6d] pl-[18%]">
    <div class="justify-left text-left items-left uppercase">
        <h1 class="title mb-4 text-[#d3a870] text-xl font-bold">Contact</h1>
    </div>
    <div class="mb-2">
        <input type="text" name="first_name" id="first_name" placeholder="First Name"
            value="{{ auth()->check() && $user->first_name ? $user->first_name : old('first_name') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('first_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-2">
        <input type="text" name="last_name" id="last_name" placeholder="Last Name"
            value="{{ auth()->check() && $user->last_name ? $user->last_name : old('last_name') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('last_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="">

        <input type="number" name="mobile_number" id="mobile_number" placeholder="Phone Number"
            value="{{ auth()->check() && $user->mobile_number ? $user->mobile_number : old('mobile_number') }}""
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('mobile_number')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="justify-left text-left items-left uppercase mt-10">
        <h1 class="title mb-4 text-[#d3a870] text-xl font-bold">Address</h1>
    </div>

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
</div>
