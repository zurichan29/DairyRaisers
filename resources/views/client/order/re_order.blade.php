@extends('layouts.client')
<style>
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
@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('order_history') }}">All Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Re-Order: {{ $order->order_number }}</li>
        </ol>
    </nav>
    <section class="mt-12">
        <form method="POST" action="{{ route('orders.re-order.place', ['id' => $order->id]) }}" class=""
            id="addressForm" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid mt-4">
                <div class="row w-100 justify-content-center">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body">
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
                                                    <h4 id="address-text" class="text-primary">ADDRESS</h4>
                                                </div>
                                                <div class="row mb-3">
                                                    <a id="editAddressBtn" class="btn btn-sm btn-outline-primary"
                                                        href="{{ URL::secure(route('order.edit.address', ['id' => $order->id])) }}">Edit
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
                                                @include('client.checkout.inputAddressForm')])
                                            @endif
                                        </div>
                                    @else
                                        @include('client.checkout.inputAddressForm')
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
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
                                            <option value="Cash On Delivery">Cash On Delivery</option>
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
                                            id="reference_number" placeholder="Reference number or control number" disabled
                                            readonly>
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
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="">
                                    <div class="row mb-3">
                                        <h4 class="text-primary">CART</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach ($items as $item)
                                                <x-order-display :name="$item['name']" :variant="$item['variant']" :price="$item['price']"
                                                    :quantity="$item['quantity']" :total="$item['total']" :img="$item['img']" />
                                            @endforeach
                                            <div class="border-top mb-3"></div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="remarks" id="remarks"
                                                    placeholder="Remarks">
                                                <label for="remarks">Remarks</label>
                                            </div>
                                            <div class="border-top mb-3"></div>
                                            <div class="row align-items-center mb-3">
                                                <h5 class="font-weight-bold">TOTAL:
                                                    ₱{{ $grandTotal . '.00' }}</h5>
                                                <h5 class="font-weight-bold">Delivery Fee: ₱{{ $delivery_fee }}.00</h5>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <h4 class="font-weight-bold text-primary">GRAND TOTAL:
                                                    ₱{{ $grandTotal + $delivery_fee . '.00' }}</h4>
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
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js"></script>
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Function to disable elements when Pick Up option is selected
        function disablePickUpElements() {
            $('#editAddressBtn').prop('disabled', true);
            $('#editAddressBtn').addClass('disabled');
            $('#defaultAddressSelect').prop('disabled', true);
            $('#defaultAddressSelect').prop('readonly', true);
            $('#address-text').removeClass('text-primary');
            $('#address-text').addClass('text-secondary');

            $('#regionSelect').prop('disabled', true);
            $('#regionSelect').prop('readonly', true);

            $('#provinceSelect').prop('disabled', true);
            $('#provinceSelect').prop('readonly', true);

            $('#municipalitySelect').prop('disabled', true);
            $('#municipalitySelect').prop('readonly', true);

            $('#barangaySelect').prop('disabled', true);
            $('#barangaySelect').prop('readonly', true);

            $('#street').prop('disabled', true);
            $('#street').prop('readonly', true);

            $('#zip_code').prop('disabled', true);
            $('#zip_code').prop('readonly', true);

            $('#label').prop('disabled', true);
            $('#label').prop('readonly', true);
        }

        // Function to enable elements when Delivery option is selected
        function enablePickUpElements() {
            $('#editAddressBtn').prop('disabled', false);
            $('#editAddressBtn').removeClass('disabled');
            $('#defaultAddressSelect').prop('disabled', false);
            $('#defaultAddressSelect').prop('readonly', false);
            $('#address-text').removeClass('text-secondary');
            $('#address-text').addClass('text-primary');

            $('#regionSelect').prop('disabled', false);
            $('#regionSelect').prop('readonly', false);

            $('#provinceSelect').prop('disabled', false);
            $('#provinceSelect').prop('readonly', false);

            $('#municipalitySelect').prop('disabled', false);
            $('#municipalitySelect').prop('readonly', false);

            $('#barangaySelect').prop('disabled', false);
            $('#barangaySelect').prop('readonly', false);

            $('#street').prop('disabled', false);
            $('#street').prop('readonly', false);

            $('#zip_code').prop('disabled', false);
            $('#zip_code').prop('readonly', false);

            $('#label').prop('disabled', false);
            $('#label').prop('readonly', false);
        }

        // Initially call the appropriate function based on the selected radio button
        if ($('#pickup').prop('checked')) {
            disablePickUpElements();
        } else {
            enablePickUpElements();
        }

        // Listen for changes on the radio buttons
        $('input[name="delivery_option"]').change(function() {
            if ($(this).val() === 'Pick Up') {
                disablePickUpElements();
            } else {
                enablePickUpElements();
            }
        });

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
