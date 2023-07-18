@extends('layouts.client')
@section('content')
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner-border {
            width: 4rem;
            /* Adjust the size as needed */
            height: 4rem;
            /* Adjust the size as needed */
        }
    </style>

    <div id="loading-animation-id" class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>


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
            <div class="">
                <h1>Payments</h1>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewPaymentOptions">
                    View Payment Options
                </button>

                <!-- Modal -->
                <div class="modal fade" id="viewPaymentOptions" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Accepting Payments:</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Account Name</th>
                                                <th>Account No.</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payment_methods as $method)
                                                <tr>
                                                    <td>{{ $method->type }}</td>
                                                    <td>{{ $method->account_name }}
                                                    </td>
                                                    <td>{{ $method->account_number }}</td>
                                                    <td class="text-center">
                                                        @if ($method->status == 'ACTIVATED')
                                                            <p class="badge bg-success text-center text-wrap status-badge"
                                                                style="width: 6rem;">
                                                                ONLINE
                                                            </p>
                                                        @else
                                                            <p class="badge bg-danger text-center text-wrap status-badge"
                                                                style="width: 6rem;">
                                                                OFFLINE
                                                            </p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="payment_method" name="payment_method" aria-label="Payment Method">
                        <option selected>Select</option>
                        @foreach ($payment_methods as $method)
                            @if ($method->status == 'ACTIVATED')
                                <option value="{{ $method->id }}">{{ $method->type }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="payment_method">Payment Method *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="reference_number" id="reference_number"
                        placeholder="Reference number or control number">
                    <label for="reference_number">Reference / Control No. *</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Uploade or Browse your Payment Reciept *</label>
                    <input class="form-control" type="file" name="formFile" id="formFile">
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
                        @include('client.checkout.inputAddressForm');
                    @endif
                @else
                    @include('client.checkout.inputAddressForm');
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js"></script>
    <script>
        function extractReferenceNumber(file) {
            return new Promise(function(resolve, reject) {
                // Show loading animation while processing
                // You can customize this based on your preferred loading animation
                // For example, display a spinner or show a loading message
                // Replace 'loading-animation-id' with the ID or selector of your loading animation element
                $('#loading-animation-id').show();

                Tesseract.recognize(file, 'eng')
                    .then(function(result) {
                        console.log(result);

                        var referenceNumberLine = null;
                        var pattern = /Ref No\. (\d+\s\d+\s\d+)/;

                        // Iterate over the words and find the line with the reference number
                        result.data.words.forEach(function(word) {
                            if (pattern.test(word.line.text)) {
                                referenceNumberLine = word.line.text;
                                return false; // Exit the loop if a match is found
                            }
                        });

                        var referenceNumber = null;
                        var referenceNumberWithoutSpaces = null;

                        if (referenceNumberLine) {
                            var matches = referenceNumberLine.match(pattern);
                            referenceNumber = matches ? matches[1] : null;
                            referenceNumberWithoutSpaces = referenceNumber ? referenceNumber.replace(/\s/g,
                                '') : null;
                        }

                        console.log('Reference Number:', referenceNumber);
                        console.log('Reference Number without Spaces:', referenceNumberWithoutSpaces);

                        // Hide the loading animation
                        $('#loading-animation-id').hide();

                        // Resolve the promise with the extracted reference number
                        resolve(referenceNumberWithoutSpaces);
                    })
                    .catch(function(error) {
                        console.error(error);
                        // Hide the loading animation
                        $('#loading-animation-id').hide();
                        // Reject the promise with the error
                        reject(error);
                    });
            });
        }
        $(document).ready(function() {
            $('#loading-animation-id').hide();
            $('#formFile').on('change', function() {
                var fileInput = this;
                var file = fileInput.files[0];
                // Check if Gcash type is selected in the form
                // Replace 'select-form-id' with the ID or selector of your select form element
                // Get the selected payment method text
                var selectedPaymentMethod = $('#payment_method option:selected').text();

                // Check if the selected payment method is 'gcash'
                if (selectedPaymentMethod === 'Gcash') {
                    console.log(file);
                    // Call the function to extract the reference number
                    extractReferenceNumber(file)
                        .then(function(referenceNumberWithoutSpaces) {
                            // Assign the extracted reference number to an input text field
                            // Replace 'input-text-id' with the ID or selector of your input text field
                            $('#reference_number').val(referenceNumberWithoutSpaces);
                        })
                        .catch(function(error) {
                            // Handle the error if extraction fails
                            console.error(error);
                        });
                }
            });
        });
    </script>


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
@endsection
