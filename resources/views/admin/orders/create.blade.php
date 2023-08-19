@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        @error('customer_details')
            <script>
                $(document).ready(function() {
                    showNotification('error', 'No Selected Customer', 'Please select a customer before proceeding.');
                });
            </script>
        @enderror
        <div class="container ">

            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">All Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Order</li>
                </ol>
            </nav>
            <form action="{{ route('admin.orders.store_order') }}" method="POST">
                @csrf

                <div class="card shadow mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Select Customer</h5>
                        <div class="">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addCustomerDetailsModal"
                                class="btn btn-sm btn-primary me-3">Add
                                Customer
                                Details</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#editCustomerDetailsModal"
                                id="edit-customer-details-btn" class="btn btn-sm btn-primary">Edit
                                Selected Customer</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="customerTable" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Store</th>
                                        <th scope="col">Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer_details as $customer)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="customer_details"
                                                        value="{{ $customer->id }}" id="{{ $customer->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $customer->first_name . ' ' . $customer->last_name }}</td>
                                            <td>{{ $customer->store_name }}</td>
                                            <td>{{ $customer->complete_address }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Select Products</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="dataTable" style="font-size: 14px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Select</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Variant</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    @if ($product->status == 'AVAILABLE' || $product->stocks > 0)
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="{{ $product->id }}"
                                                                        id="product_{{ $product->id }}">
                                                                </div>
                                                            </td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>₱{{ $product->price }}.00</td>
                                                            <td>{{ $product->variant->name }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-ccenter">
                                    <h5 class="card-title">Selected Products</h5>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="card-body">
                                    <div id="selectedProductsContainer" class="row">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <!-- add costumer details Modal -->
            <div class="modal fade" id="addCustomerDetailsModal" tabindex="-1"
                aria-labelledby="addCustomerDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="addCustomerDetailsModalLabel">Create Customer Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" id="addCustomerDetailsForm">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                placeholder="Name">
                                            <label for="first_name">First Name *</label>
                                            <div id="add-customer_details-first_name-error" class="error-container"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="last_name" id="last_name"
                                                placeholder="Name">
                                            <label for="last_name">Last Name *</label>
                                            <div id="add-customer_details-last_name-error" class="error-container"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="mobile_number" id="mobile_number"
                                        placeholder="mobile_number">
                                    <label for="mobile_number">Phone No. *</label>
                                    <div id="add-customer_details-mobile_number-error" class="error-container"></div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="store_name" id="store_name"
                                        placeholder="Name">
                                    <label for="store_name">Store Name *</label>
                                    <div id="add-customer_details-store_name-error" class="error-container"></div>
                                </div>

                                <div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="regionSelect" name="region"
                                            aria-label="select region">
                                            <option disabled selected value="">Select your region</option>
                                        </select>
                                        <label for="payment_method">Region *</label>
                                        <div id="add-customer_details-region-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="provinceSelect" name="province"
                                            aria-label="select province">
                                            <option disabled selected value="">Select your province</option>
                                        </select>
                                        <label for="provinceSelect">Province *</label>
                                        <div id="add-customer_details-province-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="municipalitySelect" name="municipality"
                                            aria-label="select municipality">
                                            <option disabled selected value="">Select your municipality</option>
                                        </select>
                                        <label for="municipalitySelect">Municipality *</label>
                                        <div id="add-customer_details-municipality-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="barangaySelect" name="barangay"
                                            aria-label="select barangay">
                                            <option disabled selected value="">Select your barangay</option>
                                        </select>
                                        <label for="barangaySelect">Barangay *</label>
                                        <div id="add-customer_details-barangay-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="street" id="street"
                                            placeholder="enter street">
                                        <label for="street">Street Name, Building, House No. *</label>
                                        <div id="add-customer_details-street-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="zip_code" id="zip_code"
                                            placeholder="enter zip_code">
                                        <label for="zip_code">Zip Code *</label>
                                        <div id="add-customer_details-zip_code-error" class="error-container"></div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                        placeholder="enter remarks">
                                    <label for="remarks">Remarks</label>
                                    <div id="add-customer_details-remarks-error" class="error-container"></div>
                                </div>

                                <button type="submit" id="addCustomerDetailsBtn" class="btn btn-primary mb-3">
                                    <span class="loading-spinner" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </span>
                                    <span class="btn-text">Submit</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- edit costumer details Modal -->
            <div class="modal fade" id="editCustomerDetailsModal" tabindex="-1"
                aria-labelledby="editCustomerDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="editCustomerDetailsModalLabel">Edit Customer Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" id="editCustomerDetailsForm">

                                <input type="hidden" name="customer_id" id="editCustomerId">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="first_name"
                                                id="edit-first_name" placeholder="Name">
                                            <label for="edit-first_name">First Name *</label>
                                            <div id="edit-customer_details-first_name-error" class="error-container">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="last_name"
                                                id="edit-last_name" placeholder="Name">
                                            <label for="edit-last_name">Last Name *</label>
                                            <div id="edit-customer_details-last_name-error" class="error-container"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="mobile_number"
                                        id="edit-mobile_number" placeholder="mobile_number">
                                    <label for="edit-mobile_number">Phone No. *</label>
                                    <div id="edit-customer_details-mobile_number-error" class="error-container"></div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="store_name" id="edit-store_name"
                                        placeholder="Name">
                                    <label for="edit-store_name">Store Name *</label>
                                    <div id="edit-customer_details-store_name-error" class="error-container"></div>
                                </div>

                                <div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="edit-regionSelect" name="region"
                                            aria-label="select region">
                                            <option disabled selected value="">Select your region</option>
                                        </select>
                                        <label for="edit-regionSelect">Region *</label>
                                        <div id="edit-customer_details-region-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="edit-provinceSelect" name="province"
                                            aria-label="select province">
                                            <option disabled selected value="">Select your province</option>
                                        </select>
                                        <label for="edit-provinceSelect">Province *</label>
                                        <div id="edit-customer_details-province-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="edit-municipalitySelect" name="municipality"
                                            aria-label="select municipality">
                                            <option disabled selected value="">Select your municipality</option>
                                        </select>
                                        <label for="edit-municipalitySelect">Municipality *</label>
                                        <div id="edit-customer_details-municipality-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="edit-barangaySelect" name="barangay"
                                            aria-label="select barangay">
                                            <option disabled selected value="">Select your barangay</option>
                                        </select>
                                        <label for="edit-barangaySelect">Barangay *</label>
                                        <div id="edit-customer_details-barangay-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="street" id="edit-street"
                                            placeholder="enter street">
                                        <label for="edit-street">Street Name, Building, House No. *</label>
                                        <div id="edit-customer_details-street-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="zip_code" id="edit-zip_code"
                                            placeholder="enter zip_code">
                                        <label for="edit-zip_code">Zip Code *</label>
                                        <div id="edit-customer_details-zip_code-error" class="error-container"></div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="remarks" id="edit-remarks"
                                        placeholder="enter remarks">
                                    <label for="edit-remarks">Remarks</label>
                                    <div id="edit-customer_details-remarks-error" class="error-container"></div>
                                </div>

                                <button type="submit" id="editCustomerDetailsBtn" class="btn btn-primary mb-3">
                                    <span class="loading-spinner" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </span>
                                    <span class="btn-text">Submit</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var dataTable = null;
                var customerTable = null;
                var currentDataTablePage = 1;
                var currentCustomerTablePage = 1;

                dataTable = $('#dataTable').DataTable();
                customerTable = $('#customerTable').DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                });

                // Function to update the selected products container
                function updateSelectedProducts() {
                    var selectedProducts = [];
                    var total = 0;
                    // Loop through all the checkboxes
                    $('input[type="checkbox"]').each(function() {
                        if ($(this).is(':checked')) {
                            var productId = $(this).val();
                            var quantity = parseFloat($('#quantity_' + productId).val()) || 0;
                            var discount = parseFloat($('#discount_' + productId).val()) || 0;
                            var price = parseFloat('{{ $product->price }}');

                            // Calculate total price after discount per quantity
                            var totalPrice = price - discount * quantity;

                            console.log(price - discount * quantity);

                            // Update the total in the UI
                            $('#total_' + productId).text('₱' + totalPrice.toFixed(2));

                            total += totalPrice;

                            selectedProducts.push({
                                product_id: productId,
                                quantity: quantity,
                                discount: discount
                            });
                        }
                    });

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    // Update the selected products container with the selected product data
                    $.ajax({
                        url: "{{ route('admin.orders.selected_products') }}",
                        type: "POST",
                        data: {
                            products: selectedProducts
                        },
                        success: function(response) {
                            // Update the selected products container with the response
                            $("#selectedProductsContainer").html(response.html);

                            // Update the total in the UI
                            $("#total").text(response.total);
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }

                // Listen for input changes and update the selected products container
                $(document).on('change', 'input[type="checkbox"], input.quantity-input, input.discount-input',
                    function() {
                        updateSelectedProducts();
                    });

                // Function to initialize DataTable
                function initializeCustomerTable(data) {
                    customerTable = $('#customerTable').DataTable({
                        data: data,
                        columns: [{
                                data: null,
                                render: function(data, type, row) {
                                    return '<div class="form-check"><input class="form-check-input" type="radio" name="customer_details" value="' +
                                        data.id + '" id="' + data.id + '"></div>';
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return data.first_name + ' ' + data.last_name;
                                }
                            },
                            {
                                data: 'store_name'
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return data.complete_address;
                                }
                            }
                        ],
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                    });
                }

                // Function to fetch updated data and refresh DataTable
                function refreshCustomerTable(select = null) {
                    currentCustomerTablePage = customerTable.page.info().page + 1;
                    // Get the CSRF token value
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.orders.fetch_customer_details') }}", // Replace with your route URL
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (customerTable) {
                                customerTable.destroy();
                            }
                            initializeCustomerTable(response);
                            customerTable.page(currentCustomerTablePage - 1).draw('page');

                            if (select) {
                                $('input[type="radio"][name="customer_details"][value="' + select + '"]')
                                    .prop('checked',
                                        true);
                            }

                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                $('input[name="customer_details"]').on('change', function() {
                    var selectedValue = $('input[name="customer_details"]:checked').val();
                    console.log(selectedValue);
                });

                function convertRegionToId(region_name) {
                    return new Promise(function(resolve, reject) {
                        $.getJSON('/js/philippine_address_2019v2.json')
                            .done(function(data) {
                                var regionNameToFind = region_name;
                                var regionId;

                                for (var regionIdKey in data) {
                                    if (data.hasOwnProperty(regionIdKey)) {
                                        var regionData = data[regionIdKey];
                                        if (regionData.region_name === regionNameToFind) {
                                            regionId = regionIdKey;
                                            break; // Stop the loop once a match is found
                                        }
                                    }
                                }

                                if (regionId) {
                                    console.log("Region ID for " + regionNameToFind + ": " + regionId);
                                    resolve(regionId); // Resolve the Promise with the regionId
                                } else {
                                    console.log("Region not found for " + regionNameToFind);
                                    resolve(null); // Resolve the Promise with null
                                }
                            })
                            .fail(function(jqxhr, textStatus, error) {
                                console.log("Error fetching JSON data: " + error);
                                reject(error); // Reject the Promise if there's an error
                            });
                    });
                }

                function getCustomerDetails(data, type) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.orders.get_customer_details') }}",
                        type: "POST",
                        data: {
                            id: data,
                        },
                        success: function(response) {
                            switch (type) {
                                case 'address':
                                    $('#customer_name').text();
                                    $('#customer_store_name').text();
                                    $('#customer_mobile_number').text();
                                    $('#customer_address').text();
                                    $('#customer_remarks').text();

                                    $('#customer_name').text(response.first_name + ' ' + response
                                        .last_name);
                                    $('#customer_store_name').text(response.store_name);
                                    $('#customer_mobile_number').text(response.mobile_number);
                                    $('#customer_address').text(response.complete_address);
                                    $('#customer_remarks').text(response.remarks);
                                    break;

                                case 'all':
                                    // console.log(response);
                                    convertRegionToId(response.region)
                                        .then(function(regionId) {
                                            // Use the regionId here or perform further operations
                                            console.log("Returned Region ID:", regionId);
                                            $('#edit-first_name').val(response.first_name);
                                            $('#edit-last_name').val(response.last_name);
                                            $('#edit-mobile_number').val(response.mobile_number);
                                            $('#edit-store_name').val(response.store_name);
                                            $('#edit-regionSelect').val(regionId);
                                            $('#edit-provinceSelect').val(response.province);
                                            $('#edit-municipalitySelect').val(response.municipality);
                                            $('#edit-barangaySelect').val(response.barangay);
                                            $('#edit-street').val(response.street);
                                            $('#edit-zip_code').val(response.zip_code);
                                        })
                                        .catch(function(error) {
                                            // Handle errors, if any
                                            console.error("Error occurred:", error);
                                        });



                                    break;

                                default:
                                    break;
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }

                function refreshCustomerDetails(select = null) {
                    // // Clear existing options
                    // $('#customer_details').empty();

                    // // Add the default "Select customer" option
                    // $('#customer_details').append('<option selected value="">Select customer</option>');

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.orders.fetch_customer_details') }}",
                        type: "POST",
                        data: null,
                        success: function(response) {
                            response.forEach(function(customer) {
                                $('#customer_details').append(
                                    `<option value="${customer.id}">${customer.first_name} ${customer.last_name}  | ${customer.store_name}</option>`
                                );
                            });

                            // if (select) {
                            //     $('#customer_details').val(select);
                            // }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }

                $(document).on('click', '#edit-customer-details-btn', function() {
                    var selectedCustomerId = $('input[name="customer_details"]:checked').val();
                    $('#editCustomerId').val(selectedCustomerId);
                    console.log($('#editCustomerId').val() + ' = ' + selectedCustomerId);
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.orders.populate_address') }}",
                        type: "POST",
                        data: {
                            id: selectedCustomerId
                        },
                        success: function(response) {

                            // Populate the form with the received customer data and address details
                            $('#edit-first_name').val(response.customer.first_name);
                            $('#edit-last_name').val(response.customer.last_name);
                            $('#edit-mobile_number').val(response.customer.mobile_number);
                            $('#edit-store_name').val(response.customer.store_name);
                            $('#edit-street').val(response.customer.street);
                            $('#edit-zip_code').val(response.customer.zip_code);
                            $('#edit-remarks').val(response.customer.remarks);

                            // Populate the region <select> with the regions from the response
                            var regionSelect = $('#edit-regionSelect');
                            regionSelect.empty(); // Clear existing options

                            // Add the default "Select your region" option
                            regionSelect.append(
                                '<option disabled selected value="">Select your region</option>'
                            );

                            // Iterate through the regions and add options to the select element
                            $.each(response.regions, function(regionCode, regionData) {
                                regionSelect.append('<option value="' + regionCode + '">' +
                                    regionData.region_name + '</option>');
                            });

                            convertRegionToId(response.customer.region)
                                .then(function(regionId) {
                                    regionSelect.val(regionId);

                                    // Populate the province <select> based on the selected region
                                    var provinceSelect = $('#edit-provinceSelect');
                                    provinceSelect.empty(); // Clear existing options

                                    // Add the default "Select your province" option
                                    provinceSelect.append(
                                        '<option disabled selected value="">Select your province</option>'
                                    );

                                    // Find the province list based on the selected region
                                    var selectedRegionData = response.addressData[regionId];
                                    if (selectedRegionData && selectedRegionData
                                        .province_list) {
                                        // Iterate through the provinces and add options to the select element
                                        $.each(selectedRegionData.province_list, function(
                                            provinceName) {
                                            provinceSelect.append('<option value="' +
                                                provinceName +
                                                '">' + provinceName + '</option>');
                                        });
                                    }

                                    provinceSelect.val(response.customer.province);

                                    // Populate the municipality <select> based on the selected province
                                    var municipalitySelect = $('#edit-municipalitySelect');
                                    municipalitySelect.empty(); // Clear existing options

                                    // Add the default "Select your municipality" option
                                    municipalitySelect.append(
                                        '<option disabled selected value="">Select your municipality</option>'
                                    );

                                    // Find the municipality list based on the selected province
                                    var selectedProvinceData = selectedRegionData.province_list[
                                        response.customer.province];
                                    if (selectedProvinceData && selectedProvinceData
                                        .municipality_list) {
                                        // Iterate through the municipalities and add options to the select element
                                        $.each(selectedProvinceData.municipality_list, function(
                                            municipalityName) {
                                            municipalitySelect.append(
                                                '<option value="' +
                                                municipalityName + '">' +
                                                municipalityName + '</option>');
                                        });
                                    }

                                    municipalitySelect.val(response.customer.municipality);

                                    // Populate the barangay <select> based on the selected municipality
                                    var barangaySelect = $('#edit-barangaySelect');
                                    barangaySelect.empty(); // Clear existing options

                                    // Add the default "Select your barangay" option
                                    barangaySelect.append(
                                        '<option disabled selected value="">Select your barangay</option>'
                                    );

                                    // Find the barangay list based on the selected municipality
                                    var selectedMunicipalityData = selectedProvinceData
                                        .municipality_list[response.customer.municipality];
                                    if (selectedMunicipalityData && selectedMunicipalityData
                                        .barangay_list) {
                                        // Iterate through the barangays and add options to the select element
                                        $.each(selectedMunicipalityData.barangay_list, function(
                                            _, barangay) {
                                            barangaySelect.append('<option value="' +
                                                barangay + '">' + barangay +
                                                '</option>');
                                        });
                                    }

                                    // Select the option that matches the customer's barangay
                                    barangaySelect.val(response.customer.barangay);
                                })
                                .catch(function(error) {
                                    // Handle errors, if any
                                    console.error("Error occurred:", error);
                                });

                            // Show the modal
                            $('#editCustomerDetailsModal').modal('show');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                });


                $('#editCustomerDetailsForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    var formData = new FormData(form);

                    var submitBtn = $(form).find('#editCustomerDetailsBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.orders.edit_customer_details') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                            showNotification('info', ' Customer Details Updated',
                                ' The customer details have been successfully updated.');

                            refreshCustomerTable(response.id);

                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            form.reset();

                            var modal = $('#editCustomerDetailsModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#edit-customer_details-' + field +
                                        '-error');

                                    // Display the error message in the respective error div
                                    errorDiv.html('<p class="text-danger">' + errorMessage +
                                        '</p>');
                                });
                            } else {
                                // Handle other error cases
                                console.error(xhr.responseText);
                            }
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();
                        }
                    });
                });

                $('#addCustomerDetailsForm').on('submit', function(e) {

                    e.preventDefault();
                    var form = this;
                    var formData = new FormData(form);

                    var submitBtn = $(form).find('#addCustomerDetailsBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.orders.create_customer_details') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                            showNotification('success', 'New Customer Added',
                                ' A new customer has been added successfully.');

                            refreshCustomerTable(response.id);

                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            form.reset();

                            var modal = $('#addCustomerDetailsModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#add-customer_details-' + field +
                                        '-error');

                                    // Display the error message in the respective error div
                                    errorDiv.html('<p class="text-danger">' + errorMessage +
                                        '</p>');
                                });
                            } else {
                                // Handle other error cases
                                console.error(xhr.responseText);
                            }
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();
                        }
                    });
                });

            });
        </script>
        <script>
            $.getJSON('/js/philippine_address_2019v2.json')
                .done(function (data) {
                    var allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR'];

                    var regions = Object.keys(data)
                        .filter(function (regionCode) {
                            return allowedRegionCodes.includes(regionCode);
                        })
                        .map(function (regionCode) {
                            return {
                                code: regionCode,
                                name: data[regionCode].region_name
                            };
                        });

                    var regionCode = $('#regionSelect').val();
                    // var regionCode = $('#edit-regionSelect').val();
                    if (regionCode === "" || regionCode === null) {
                        populateSelectOptions('#regionSelect', regions, 'Select your region');
                        // populateSelectOptions('#edit-regionSelect', regions, 'Select your region');
                    }
                })
                .fail(function () {
                    console.error('Failed to load address data.');
                });

            function populateSelectOptions(selectId, options, placeholder) {
                var select = $(selectId);
                select.empty();
                select.append($('<option disabled selected value="">' + placeholder + '</option>').text(placeholder)); // Add placeholder option
                $.each(options, function (index, option) {
                    select.append($('<option></option>').val(option.code).text(option.name));
                });
            }

            $('#regionSelect').on('change', function () {
                var regionCode = $(this).val();
                if (regionCode) {
                    $.getJSON('/js/philippine_address_2019v2.json')
                        .done(function (data) {
                            var provinceList = data[regionCode].province_list;
                            var provinces = Object.keys(provinceList).map(function (provinceName) {
                                return {
                                    code: provinceName,
                                    name: provinceName
                                };
                            });

                            populateSelectOptions('#provinceSelect', provinces, 'Select your province');
                            $('#municipalitySelect').empty().append($('<option disabled selected value="">Select your municipality</option>').text('Select your municipality'));
                            $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
                        })
                        .fail(function () {
                            console.error('Failed to load address data.');
                        });
                } else {
                    $('#provinceSelect').empty().append($('<option disabled selected value="">Select your province</option>').text('Select your province'));
                    $('#municipalitySelect').empty().append($('<option disabled selected value="">Select your municipality</option>').text('Select your municipality'));
                    $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
                }
            });

            $('#provinceSelect').on('change', function () {
                var regionCode = $('#regionSelect').val();
                var provinceName = $(this).val();
                if (provinceName && regionCode) {
                    $.getJSON('/js/philippine_address_2019v2.json')
                        .done(function (data) {
                            var municipalityList = data[regionCode].province_list[provinceName].municipality_list;
                            var municipalities = Object.keys(municipalityList).map(function (municipalityName) {
                                return {
                                    code: municipalityName,
                                    name: municipalityName
                                };
                            });

                            populateSelectOptions('#municipalitySelect', municipalities, 'Select your municipality');
                            $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
                        })
                        .fail(function () {
                            console.error('Failed to load address data.');
                        });
                } else {
                    $('#municipalitySelect').empty().append($('<option disabled selected value="">Select your municipality</option>').text('Select your municipality'));
                    $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
                }
            });

            $('#municipalitySelect').on('change', function () {
                var regionCode = $('#regionSelect').val();
                var provinceName = $('#provinceSelect').val();
                var municipalityName = $(this).val();
                if (municipalityName && provinceName && regionCode) {
                    $.getJSON('/js/philippine_address_2019v2.json')
                        .done(function (data) {
                            var barangayList = data[regionCode].province_list[provinceName].municipality_list[municipalityName].barangay_list;
                            var barangays = barangayList.map(function (barangayName) {
                                return {
                                    code: barangayName,
                                    name: barangayName
                                };
                            });

                            populateSelectOptions('#barangaySelect', barangays, 'Select your barangay');
                        })
                        .fail(function () {
                            console.error('Failed to load address data.');
                        });
                } else {
                    $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
                }
            });
        </script>
    @endif
@endsection
