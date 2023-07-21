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

    @error('remarks')
        <p>{{ $message }}</p>
    @enderror

    @error('delivery_option')
        <p>{{ $message }}</p>
    @enderror

    @error('reference_number')
        <p>{{ $message }}</p>
    @enderror

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
                    <div class="col-sm-6 d-flex flex-column align-self-stretch">
                        <div class="card-body d-flex and flex-column">
                            <div class="card w-100">
                                <div class="card-body d-flex and flex-column">
                                    <div class="">
                                        @if (auth()->check())
                                            <div class="col">
                                                <div class="row mb-3">
                                                    <h4 class="text-primary">CONTACT INFORMATION</h4>
                                                </div>
                                                <div class="form-floating-like form-floating-like-sm mb-4">
                                                    <span class="form-floating-label">Name</span>
                                                    <p class="form-control-static ms-2">
                                                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                                    </p>
                                                </div>
                                                <div class="form-floating-like form-floating-like-sm mb-4">
                                                    <span class="form-floating-label">Email</span>
                                                    <p class="form-control-static ms-2">{{ Auth::user()->email }}</p>
                                                </div>
                                                <div class="form-floating-like form-floating-like-sm mb-2">
                                                    <span class="form-floating-label">Mobile No.</span>
                                                    <p class="form-control-static ms-2">
                                                        +63{{ Auth::user()->mobile_number }}</p>
                                                </div>
                                                <div class="border-top border-secondary my-4"></div>
                                                @if ($defaultAddress)
                                                    <div class="row mb-3">
                                                        <h4 class="text-primary">ADDRESS</h4>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <a class="btn btn-sm btn-outline-primary"
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
                                                    </div>
                                                    <div class="row mb-2">
                                                        <p id="remarksAddressDisplay" class="text-secondary">remarks:
                                                            {{ $defaultAddress->remarks ? $defaultAddress->remarks : 'None' }}
                                                        </p>
                                                    </div>
                                                @else
                                                    @include('client.checkout.inputAddressForm')
                                                @endif
                                            @else
                                                @include('client.checkout.inputAddressForm')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex and flex-column">
                        <div class="card w-100">
                            <div class="card-body d-flex and flex-column">
                                <div class="">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <h4 class="text-primary">DELIVERY OPTIONS</h4>
                                        </div>
                                        <div class="px-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="delivery_option"
                                                    id="delivery" value="Delivery" checked>
                                                <label class="form-check-label" for="delivery">
                                                    Delivery
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="delivery_option"
                                                    id="pickup" value="Pick Up">
                                                <label class="form-check-label" for="pickup">
                                                    Pick Up
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                <button type="button" class="ms-2 btn btn-sm btn-outline-primary"
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
                                                <option value="Cash On Delivery">Cash On Delivery</option>
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
                                            id="reference_number" placeholder="Reference number or control number"
                                            disabled readonly>
                                        <label for="reference_number" id="reference_label">Reference / Control No.</label>
                                    </div>

                                    <div class="mb-2">
                                        <label for="formFile" class="form-label" id="file_label">Uploade or Browse your
                                            Payment
                                            Reciept</label>
                                        <input class="form-control" type="file" name="formFile" id="formFile"
                                            disabled readonly>
                                    </div>
                                    @error('formFile')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
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
                                    <div class="row mb-3">
                                        <h4 class="text-primary">CART</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach ($items as $item)
                                                <div class="row align-items-center mb-4">
                                                    <div class="col-3">
                                                        <img src="{{ asset($item->product->img) }}" class="img-fluid"
                                                            alt="Item picture">
                                                    </div>
                                                    <div class="col-9">
                                                        <h6 class="font-weight-normal">
                                                            {{ $item->product->name }}
                                                            <span class="text-secondary">
                                                                {{ ' | ' . $item->product->variant }}
                                                            </span>
                                                        </h6>
                                                        <div class="row gx-5">
                                                            <div class="col">
                                                                <div class="">
                                                                    <h6 class="text-secondary">
                                                                        ₱{{ $item->price . '.00' }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="">
                                                                    <h6 class="text-secondary">
                                                                        {{ $item->quantity }} PCS
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="border-top border-secondary mb-2"></div>
                                                        <h5 class="font-weight-bold">
                                                            Total: ₱{{ $item->price * $item->quantity . '.00' }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="border-top mb-3"></div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="remarks" id="remarks"
                                                    placeholder="Remarks">
                                                <label for="remarks">Remarks</label>
                                            </div>
                                            <div class="border-top mb-3"></div>
                                            <div class="row align-items-center mb-4">
                                                <h4 class="font-weight-bold text-primary">GRAND TOTAL:
                                                    ₱{{ $grandTotal . '.00' }}</h4>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <button type="submit" class="btn btn-primary">Place Order</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
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
                        var gcashPattern = /Ref No\. (\d+\s\d+\s\d+)/;
                        var paymayaPattern = /Reference ID ([A-Z0-9]+)/;

                        // Iterate over the words and find the line with the reference number
                        result.data.words.forEach(function(word) {
                            if (gcashPattern.test(word.line.text) || paymayaPattern.test(word.line
                                .text)) {
                                referenceNumberLine = word.line.text;
                                return false; // Exit the loop if a match is found
                            }
                        });

                        var referenceNumber = null;
                        var referenceNumberWithoutSpaces = null;

                        if (referenceNumberLine) {
                            var gcashMatches = referenceNumberLine.match(gcashPattern);
                            var paymayaMatches = referenceNumberLine.match(paymayaPattern);

                            if (gcashMatches) {
                                referenceNumber = gcashMatches[1];
                            } else if (paymayaMatches) {
                                referenceNumber = paymayaMatches[1];
                            }

                            referenceNumberWithoutSpaces = referenceNumber ? referenceNumber.replace(/\s/g,
                                '') : null;
                        }

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
            });
        });
    </script>

    <script>
        // Get the CSRF token value
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $('#payment_method').change(function() {
            if ($(this).val() === 'Cash On Delivery') {
                // Payment method is 'Cash On Delivery'
                $('#reference_number').prop('disabled', true).prop('readonly', true);
                $('#formFile').prop('disabled', true).prop('readonly', true);
                $('#reference_label').text('Reference / Control No.');
                $('#file_label').text('Upload or Browse your Payment Receipt');
            } else {
                // Payment method is not 'Cash On Delivery'
                $('#reference_number').prop('disabled', false).prop('readonly', false);
                $('#formFile').prop('disabled', false).prop('readonly', false);
                $('#reference_label').text('Reference / Control No. *');
                $('#file_label').text('Upload or Browse your Payment Receipt *');
            }
        });

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