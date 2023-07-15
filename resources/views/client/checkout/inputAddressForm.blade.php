<div class="border-r-[.1rem] border-solid border-[#136d6d] pl-[18%]">
    <div class="justify-left text-left items-left uppercase">
        <h1 class="title mb-4 text-[#d3a870] text-xl font-bold">Contact</h1>
    </div>
    <div class="mb-2">
        <input type="text" name="first_name" id="first_name" placeholder="First Name" value="{{ old('first_name') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('first_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-2">
        <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('last_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="">

        <input type="number" name="mobile_number" id="mobile_number" placeholder="Phone Number"
            value="{{ old('mobile_number') }}""
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('mobile_number')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="justify-left text-left items-left uppercase mt-10">
        <h1 class="title mb-4 text-[#d3a870] text-xl font-bold">Address</h1>
    </div>
    <div class="mb-2">
        <input type="text" name="street" placeholder="House Number, Building, Street Name"
            value="{{ old('street') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
    </div>
    <div class=" mb-2">
        <input type="text" name="barangay" placeholder="Barangay" value="{{ old('barangay') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
    </div>
    <div class=" mb-2">
        <input type="text" name="city" placeholder="City" value="{{ old('city') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
    </div>
    <div class=" mb-2">
        <input type="text" name="province" placeholder="Province" value="{{ old('province') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
    </div>
    <div class="mb-2">
        <input type="number" min="0" name="zip_code" placeholder="Zip Code" value="{{ old('zip_code') }}"
            class="box text-[#199696] text-lg pl-4 py-2 w-[75%] border-[.1rem] rounded-lg border-solid border-[#d3a870]"
            required>
        @error('zip_code')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-2">
        <label for="label">Label as:</label>
        <select name="label" id="label">
            <option value="home">home</option>
            <option value="office">office</option>
        </select>
        @error('label')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
