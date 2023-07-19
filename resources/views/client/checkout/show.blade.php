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

        .form-floating-like {
            position: relative;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }

        .form-floating-like-sm {
            padding: 0.125rem 0.25rem;
        }

        .form-floating-label {
            position: absolute;
            top: -0.5rem;
            left: 0.5rem;
            padding: 0.125rem 0.25rem;
            font-size: 0.875rem;
            background-color: #fff;
            transform-origin: top left;
            transform: translate(0, 0) scale(1);
            transition: all 0.2s ease-in-out;
            pointer-events: none;
            z-index: 1;
        }

        .form-control-static {
            padding-top: 0.5rem;
        }

        .form-floating-like:focus-within .form-floating-label,
        .form-floating-like:not(:placeholder-shown) .form-floating-label {
            transform: translate(0, -0.375rem) scale(0.85);
            background-color: #fff;
            color: #6c757d;
        }

        .form-floating-like:focus-within {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
    </style>

    <div id="loading-animation-id" class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>


    <nav class="" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <h2 class="my-3 text-center font-weight-bold text-primary">CHECKOUT ORDER</h2>
    <div class="border-top mb-2"></div>
    <section class="checkout mt-12">
        <form method="POST" action="{{ route('checkout.place_order') }}" class="custom-product" id="addressForm"
            enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-sm-6 d-flex align-self-stretch">
                        <div class="card-body d-flex and flex-column">
                            <div class="card w-100">
                                <div class="card-body d-flex and flex-column">
                                    <div class="">
                                        @if (auth()->check())
                                            @if ($defaultAddress)
                                                <div class="col">
                                                    <div class="row mb-3">
                                                        <h4 class="text-primary">CONTACT INFORMATION</h4>
                                                    </div>
                                                    <div class="form-floating-like form-floating-like-sm mb-4">
                                                        <span class="form-floating-label">Name</span>
                                                        <p class="form-control-static ms-2">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
                                                    </div>
                                                    <div class="form-floating-like form-floating-like-sm mb-4">
                                                        <span class="form-floating-label">Email</span>
                                                        <p class="form-control-static ms-2">{{ Auth::user()->email }}</p>
                                                    </div>
                                                    <div class="form-floating-like form-floating-like-sm mb-2">
                                                        <span class="form-floating-label">Mobile No.</span>
                                                        <p class="form-control-static ms-2">+63{{ Auth::user()->mobile_number }}</p>
                                                    </div>
                                                    <div class="border-top my-4"></div>
                                                    <div class="row mb-3">
                                                        <h4 class="text-primary">ADDRESS</h4>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ URL::secure(route('checkout.edit_address')) }}">Edit
                                                            this address</a>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <select name="default_address_id" class="form-select"
                                                            id="defaultAddressSelect">
                                                            @foreach ($addresses as $address)
                                                                <option value="{{ $address->id }}"
                                                                    {{ $address->id == $defaultAddress->id ? 'selected' : '' }}>
                                                                    {{ $defaultAddress->street .
                                                                        ', ' .
                                                                        $address->barangay .
                                                                        ', ' .
                                                                        $address->municipality .
                                                                        ', ' .
                                                                        $address->province .
                                                                        ', ' .
                                                                        $address->zip_code .
                                                                        ' Philippines' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        {{-- <p id="completeAddressDisplay">
                                                            {{ $defaultAddress->street .
                                                                ', ' .
                                                                $defaultAddress->barangay .
                                                                ', ' .
                                                                $defaultAddress->municipality .
                                                                ', ' .
                                                                $defaultAddress->province .
                                                                ', ' .
                                                                $defaultAddress->zip_code .
                                                                ' Philippines' }}
                                                        </p> --}}
                                                    </div>
                                                    <div class="row mb-2">
                                                        <p id="remarksAddressDisplay" class="text-secondary">remarks:
                                                            {{ $defaultAddress->remarks ? $defaultAddress->remarks : 'None' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @else
                                                @include('client.checkout.inputAddressForm');
                                            @endif
                                        @else
                                            @include('client.checkout.inputAddressForm');
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex align-self-stretch">
                        <div class="card-body d-flex and flex-column">
                            <div class="card w-100">
                                <div class="card-body d-flex and flex-column">
                                    <div class="">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <h4 class="text-primary">PAYMENTS</h4>
                                            </div>
                                            <div class="col">
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <button type="button" class="ms-2 btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#viewPaymentOptions">
                                                        View Payment Options
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="viewPaymentOptions" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Accepting
                                                            Payments:</h5>
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
                                            <select class="form-select" id="payment_method" name="payment_method"
                                                aria-label="Payment Method">
                                                <option selected>Select</option>
                                                @foreach ($payment_methods as $method)
                                                    @if ($method->status == 'ACTIVATED')
                                                        <option value="{{ $method->id }}">{{ $method->type }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label for="payment_method">Payment Method *</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="reference_number"
                                                id="reference_number" placeholder="Reference number or control number">
                                            <label for="reference_number">Reference / Control No. *</label>
                                        </div>

                                        <div class="mb-2">
                                            <label for="formFile" class="form-label">Uploade or Browse your Payment
                                                Reciept *</label>
                                            <input class="form-control" type="file" name="formFile" id="formFile">
                                        </div>
                                        @error('formFile')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






            @foreach ($items as $item)
                <div class="col-sm-3 grid grid-cols-3 gap-1 justify-center items-center px-[10%]">
                    <a href="detail/{{ $item['productId'] }}">
                        <img src="{{ $item['img'] }}" class="w-50">
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
                        // var defaultAddressDisplay = document.getElementById('completeAddressDisplay');
                        // var remarksAddressDisplay = document.getElementById('remarksAddressDisplay');
                        // var selectedOption = document.querySelector('#defaultAddressSelect option:checked');
                        // defaultAddressDisplay.textContent = selectedOption.textContent;
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
