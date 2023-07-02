<x-layout>
    @include('client.components.header')
    <div class="items-left flex text-2xl justify-between pl-8 pt-28">
        <div class="font-semibold delay-75 text-[#5f9ea0] items-center text-center">
            <a href="/cart" class="title text-center my-10 text-[#199696] hover:underline">Cart <i
                    class="fa-solid fa-angle-right"></i></a>
            <a href="/checkout" class="title text-center my-10 text-[#199696] font-bold hover:underline">Information</a>
        </div>
    </div>
    <section class="checkout mt-12">

        <form method="POST" action="{{ route('checkout.place_order') }}" class="custom-product">
            @csrf
            <div class="justify-center text-center items-center uppercase">
                <h1 class="title text-center mb-4 text-[#199696] text-5xl font-bold">checkout order</h1>
            </div>

            @if (auth()->check())
                @if ($defaultAddress)
                    <div class="bg-gray-200 p-4">
                    <h2 class="text-lg font-semibold">Address</h2>
                    <p id="completeAddressDisplay">
                        {{ $defaultAddress->barangay .
                            ', ' .
                            $defaultAddress->city .
                            ', ' .
                            $defaultAddress->province .
                            ', ' .
                            $defaultAddress->zip_code .
                            ' Philippines' }}
                    </p>
                    <p id="remarksAddressDisplay">remarks: {{ $defaultAddress->remarks }}</p>
                    </div>

                    <div class="bg-gray-200 p-4 mt-4">
                        <h2 class="text-lg font-semibold">Contact Information</h2>
                        <p>Email: {{ Auth::user()->email }}</p>
                        <p>Phone: {{ Auth::user()->mobile_number }}</p>
                    </div>

                    <select name="default_address_id" id="defaultAddressSelect">
                        @foreach ($addresses as $address)
                            <option value="{{ $address->id }}"
                                {{ $address->id == $defaultAddress->id ? 'selected' : '' }}>
                                {{ $address->barangay . ', ' . $address->city . ', ' . $address->province . ', ' . $address->zip_code . ' Philippines' }}
                            </option>
                        @endforeach
                    </select>
                    <a href="{{ URL::secure(route('checkout.edit_address')) }}">Edit this address</a>
                @else
                    @include('client.page.checkout.inputAddressForm');
                @endif
            @else
                @include('client.page.checkout.inputAddressForm');
            @endif

            @foreach ($items as $item)
                <div class="col-sm-3 grid grid-cols-3 gap-1 justify-center items-center px-[10%]">
                    <a href="detail/{{ $item['productId'] }}">
                        <img src="{{ $item['img'] }}"
                            class="trending-img w-32 border-[.1rem] rounded-lg border-solid border-[#d3a870]">
                    </a>

                    <div class="">
                        <h2 class="text-2xl text-[#5f9ea0] font-semibold">{{ $item['name'] }}</h2>
                        <a href="/removecart/{{ $item['cartId'] }}"
                            class="option-btn block w-[8rem] mt-4 text-lg p-[.3rem] relative rounded-xl bg-[#d3a870] text-white text-center shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)]">Remove</a>
                    </div>


                    <div class="flex flex-wrap gap-2 py-6 pl-[6rem]">
                        <h2 class="text-[#d2691e] text-2xl font-semibold pb-2">₱ {{ $item['price'] }}</h5>
                            <input type="number" min="1" value="1" name="p_qty"
                                class="qty mt-2 mr-0 py-[.5rem] pl-4 pr-2 rounded-lg text-[#199696] w-[5rem] text-center shadow-[0_.5px_10px_rgba(0,0,0,.3)]">
                    </div>

                    <div class="mt-4 grid grid-cols-1 w-[34rem] border-t-[.1rem] border-solid border-[#136d6d]">
                        <p class="option-btn text-2xl text-center text-[#5f9ea0] pt-4 pl-[45%]">
                            Subtotal: <span class="text-[#d2691e] text-2xl font-semibold pl-10">₱
                                {{ $item['total'] }}</span></p>
                        <div class="mt-4 w-[34rem] border-t-[.1rem] border-solid border-[#136d6d]">
                            <p class="option-btn text-2xl text-center text-[#5f9ea0] pt-4 pl-[45%]">
                                Total: <span class="text-[#d2691e] text-2xl font-semibold pl-10">₱
                                    {{ $item['total'] }}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <label for="remarks">Remarks:</label>
            <input type="text" name="remarks" id="remarks" value="{{ old('remarks') }}">
            <h1>{{ $grandTotal }}</h1>

            <button type="submit">Place Order</button>
        </form>

    </section>

    <script>
        // Get the CSRF token value
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Handle the change event of the select element
        document.getElementById('defaultAddressSelect').addEventListener('change', function() {
            var selectedAddressId = this.value;

            // Send an AJAX request to update the default address
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/checkout/default_address', true);
            xhr.setRequestHeader('Content-type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Parse the JSON response
                        var response = JSON.parse(xhr.responseText);

                        // Handle the success response
                        console.log(response.address);

                        // Access the returned address
                        var address = response.address;
                        var remarks = address['remarks'];
                        if (remarks == null || '') {
                            remarks = 'None';
                        }

                        // Update the UI to reflect the new default address
                        var addresses = document.querySelectorAll('#defaultAddressSelect option');
                        addresses.forEach(function(address) {
                            if (address.value === selectedAddressId) {
                                address.selected = true;
                            } else {
                                address.selected = false;
                            }
                        });

                        // Update the display of the default address
                        var defaultAddressDisplay = document.getElementById('completeAddressDisplay');
                        var remarksAddressDisplay = document.getElementById('remarksAddressDisplay');
                        var selectedOption = document.querySelector('#defaultAddressSelect option:checked');
                        defaultAddressDisplay.textContent = selectedOption.textContent;
                        remarksAddressDisplay.textContent = remarks;
                    } else {
                        // Handle the error response
                        console.log('Error:', xhr.status);
                    }
                }
            };
            var data = JSON.stringify({
                default_address_id: selectedAddressId
            });
            xhr.send(data);
        });
    </script>
    @include('client.components.footer')
</x-layout>
