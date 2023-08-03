@extends('layouts.admin')

@section('content')
    {{-- NAV PILLS --}}
    <ul class="nav nav-pills nav-fill flex-row mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-milk-tab" data-bs-toggle="pill" data-bs-target="#pills-milk" type="button"
                role="tab" aria-controls="pills-milk" aria-selected="true">
                <i class="fa-solid fa-bottle-water"></i> Milks</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-buffalo-tab" data-bs-toggle="pill" data-bs-target="#pills-buffalo"
                type="button" role="tab" aria-controls="pills-buffalo" aria-selected="false">
                <i class="fa-solid fa-cow"></i> Buffalos</button>
        </li>
    </ul>

    {{-- CONTENT OF NAV PILLS --}}
    <div class="tab-content p-2" id="pills-tabContent">
        {{-- CONTENT 1 --}}
        <div class="tab-pane fade show active" id="pills-milk" role="tabpanel" aria-labelledby="pills-milk-tab"
            tabindex="0">
            <!-- Page Heading -->
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <h1 class="h3 text-gray-800">Milk Stocks : <span>{{ $liters }}</span> Liters</h1>

                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#incrementMilkStock"
                        class="btn btn-primary btn-icon-split" style="margin-right: .5rem;">
                        <span class="icon text-white-50">
                            <i class="fa-solid fa-circle-plus"></i>
                        </span>
                        <span class="text">
                            Update Milk Stocks
                        </span>
                    </button>
                    
                    <!-- MODAL Add/Update Milk Stock -->
                    <div class="modal fade" id="incrementMilkStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Add Milks</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="incrementMilkStockForm">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <div>
                                                <label for="date_created">Date Produced</label>
                                            </div>
                                            <input type="date" class="form-control" name="date_created" id="date_created"
                                                placeholder="Date Created">
                                            <span id="dateCreatedSelected"></span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="quantity" id="quantity"
                                                placeholder="Quantity">
                                            <label for="quantity">Quantity (Liter)</label>
                                        </div>

                                        <button type="button" id="deleteBuffalosBtn" class="btn btn-primary mb-3">
                                            <span class="loading-spinner" style="display: none;">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </span>
                                            <span class="delete-btn">Delete</span>
                                        </button>
                                        <button type="submit" id="incrementMilkStockBtn" class="btn btn-primary mb-3">
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


                    <button type="button" data-bs-toggle="modal" data-bs-target="#sellMilkStock"
                        class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <span class="text">
                            Sell Milks
                        </span>
                    </button>
                </div>
                
                <!-- MODAL Sell Milk Stock -->
                <div class="modal fade" id="sellMilkStock" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="exampleModalLabel">Sell Milk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="sellMilkStockForm">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <div>
                                            <label for="date_created">Date of Sell</label>
                                        </div>
                                        <input type="date" class="form-control" name="date_created" id="date_created"
                                            placeholder="Date Created">
                                        <span id="dateCreatedSelected"></span>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="quantity" id="quantity"
                                            placeholder="Quantity">
                                        <label for="quantity">Quantity (Liter)</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="buyers_name" id="buyers_name"
                                            placeholder="Buyer's Name">
                                        <label for="buyers_name">Buyer's Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="buyers_address"
                                            id="buyers_address" placeholder="Buyer's Address">
                                        <label for="buyers_address">Buyer's Address</label>
                                    </div>
                                    <button type="submit" id="sellMilkStockBtn" class="btn btn-primary mb-3">
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

            <!-- Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="confirmationMessage"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary" id="confirmActionBtn">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT 2 --}}
        <div class="tab-pane fade" id="pills-buffalo" role="tabpanel" aria-labelledby="pills-buffalo-tab"
            tabindex="0">
            <!-- Page Heading -->
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <h1 class="h3 text-gray-800">Buffalos : <span></span></h1>
                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#updateBuffalos"
                        class="btn btn-primary btn-icon-split" style="margin-right: .5rem;">
                        <span class="icon text-white-50">
                            <i class="fa-solid fa-circle-plus"></i>
                        </span>
                        <span class="text">
                            Update Buffalos
                        </span>
                    </button>
                    <!-- Add/Update Buffalo MODAL -->
                    <div class="modal fade" id="updateBuffalos" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Add Buffalo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateBuffalosForm">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="gender" id="gender"
                                                placeholder="Gender">
                                            <label for="gender">Gender of Buffalo</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="age" id="age"
                                                placeholder="age">
                                            <label for="age">Age of Buffalo</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="quantity"
                                                id="quantity" placeholder="quantity">
                                            <label for="quantity">Quantity</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <div>
                                                <label for="date_created">Date Sold</label>
                                            </div>
                                            <input type="date" class="form-control" name="date_sold" id="date_sold"
                                                placeholder="Date Sold">
                                            <span id="dateSoldSelected"></span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="buyers_name"
                                                id="buyers_name" placeholder="Buyer's Name">
                                            <label for="buyers_name">Buyer's Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="buyers_address"
                                                id="buyers_address" placeholder="Buyer's Address">
                                            <label for="buyers_address">Buyer's Address</label>
                                        </div>
                                        <button type="submit" id="updateBuffalosBtn" class="btn btn-primary mb-3">
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

                    <button type="button" data-bs-toggle="modal" data-bs-target="#sellBuffalos"
                        class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <span class="text">
                            Sell Buffalos
                        </span>
                    </button>
                </div>
                <!-- MODAL Sell Buffalo -->
                <div class="modal fade" id="sellBuffalos" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="exampleModalLabel">Sell Buffalo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="sellBuffalosForm">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="gender" id="gender"
                                            placeholder="Gender">
                                        <label for="gender">Gender of Buffalo</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="age" id="quantity"
                                            placeholder="age">
                                        <label for="age">Age of Buffalo</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="quantity"
                                            id="quantity" placeholder="quantity">
                                        <label for="quantity">Quantity</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <div>
                                            <label for="date_created">Date Sold</label>
                                        </div>
                                        <input type="date" class="form-control" name="date_sold" id="date_sold"
                                            placeholder="Date Sold">
                                        <span id="dateSoldSelected"></span>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="buyers_name" id="buyers_name"
                                            placeholder="Buyer's Name">
                                        <label for="buyers_name">Buyer's Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="buyers_address"
                                            id="buyers_address" placeholder="Buyer's Address">
                                        <label for="buyers_address">Buyer's Address</label>
                                    </div>
                                    <button type="submit" id="updateBuffalosBtn" class="btn btn-primary mb-3">
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

            <!-- Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="confirmationMessage"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary" id="confirmActionBtn">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activity Logs Table -->
        <style>
            #dataTable {
                font-size: 14px;
            }
        </style>
        <!-- Page Heading -->
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1 class="h3" style="font-size: 20px;">Milks and Buffalos Activity Logs</h1>
        </div>
    
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ADMIN ID</th>
                                <th>ACTIVITY</th>
                                <th>DATE</th>
                                <th>IP ADDRESS</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ADMIN ID</th>
                                <th>ACTIVITY</th>
                                <th>DATE</th>
                                <th>IP ADDRESS</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($activity_logs as $logs)
                                @php
                                    
                                @endphp
                                <tr>
                                    <td>{{ $logs->admin_id }}</td>
                                    <td>{{ $logs->description }}</td>
                                    <td>{{ $logs->created_at }}</td>
                                    <td>{{ $logs->ip_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--
    <h5>Milks & Buffalos Chart:</h5>
    @include('.showMap')
    --}}



    <script>
        $(document).ready(function() {
            var dataTable = null;
            dataTable = $('#dataTable').dataTable();

            // Handle form submission using AJAX
            $('#incrementMilkStockForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize the form data
                var form = this;
                var formData = new FormData(form);

                // Get the submit button, loading spinner, and button text elements within the form
                var submitBtn = $(form).find('#incrementMilkStockBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                // Disable the submit button and hide the button text, then show the loading spinner
                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                // Get the CSRF token value
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                    }
                });
                // Send AJAX request
                $.ajax({
                    url: '{{ route('admin.milk_stock.update') }}', // Updated route name
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Optionally, show a success message or redirect to another page
                        // alert('Milk data submitted successfully!');
                        showNotification('info', 'Milk stocks updated',
                            'Milk Stock updated to ' + response.quantity);

                        // Clear input fields
                        form.reset();

                        submitBtn.prop('disabled', false);
                        buttonText.show();
                        loadingSpinner.hide();

                        refreshDataTable();

                        // Close the modal
                        var modal = $('#incrementMilkStock');
                        modal.modal('hide');

                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON); // Log the error response
                        alert('Error submitting milk data. Please try again.');
                    }
                });
            });

            /// Delete button click event
            $(document).on('click', '.delete-btn', function() {
                var deleteButton = $(this);
                var milkStockId = deleteButton.data('id');
                var confirmationMessage = "Are you sure? You won't be able to revert this!";

                showConfirmationModal(confirmationMessage, function() {
                    // Proceed with deleting the payment method
                    $.ajax({
                        url: '{{ route('admin.milk_stock.delete') }}', // Replace with the actual URL for deleting the payment method
                        type: 'POST',
                        data: {
                            id: milkStockId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Remove the row from the table
                            // var row = deleteButton.closest('tr');
                            // dataTable.row(row).remove().draw();
                            // Show notification
                            showNotification('error', 'Milk deleted', response
                                .type + ' deleted.');

                            refreshDataTable();

                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                });
            });

            $('#sellMilkStockForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize the form data
                var form = this;
                var formData = new FormData(form);

                // Get the submit button, loading spinner, and button text elements within the form
                var submitBtn = $(form).find('#sellMilkStockBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                // Disable the submit button and hide the button text, then show the loading spinner
                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                // Get the CSRF token value
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                    }
                });
                // Send AJAX request
                $.ajax({
                    url: '{{ route('admin.milk_stock.sell') }}', // Updated route name
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Optionally, show a success message or redirect to another page
                        // alert('Milk data submitted successfully!');
                        showNotification('info', response.quantity + ' milk/s sold');

                        // Clear input fields
                        form.reset();

                        submitBtn.prop('disabled', false);
                        buttonText.show();
                        loadingSpinner.hide();

                        refreshDataTable();

                        // Close the modal
                        var modal = $('#sellMilkStock');
                        modal.modal('hide');

                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON); // Log the error response
                        alert('Error submitting milk data. Please try again.');
                    }
                });
            });


            $('#updateBuffalosForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize the form data
                var form = this;
                var formData = new FormData(form);

                // Get the submit button, loading spinner, and button text elements within the form
                var submitBtn = $(form).find('#updateBuffalosBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                // Disable the submit button and hide the button text, then show the loading spinner
                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                // Get the CSRF token value
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                    }
                });
                // Send AJAX request
                $.ajax({
                    url: '{{ route('admin.buffalos.submit') }}', // Updated route name
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Optionally, show a success message or redirect to another page
                        // alert('Milk data submitted successfully!');
                        showNotification('info', 'Buffalo updated', 'Buffalos updated to ' +
                            response.quantity);
                        
                        // Clear input fields
                        form.reset();

                        submitBtn.prop('disabled', false);
                        buttonText.show();
                        loadingSpinner.hide();

                        refreshDataTable();

                        // Close the modal
                        var modal = $('#updateBuffalos');
                        modal.modal('hide');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON); // Log the error response
                        alert('Error submitting buffalo data. Please try again.');
                    }
                });
            });

            $('#sellBuffalosForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize the form data
                var form = this;
                var formData = new FormData(form);

                // Get the submit button, loading spinner, and button text elements within the form
                var submitBtn = $(form).find('#sellBuffalosBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                // Disable the submit button and hide the button text, then show the loading spinner
                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                // Get the CSRF token value
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                    }
                });
                // Send AJAX request
                $.ajax({
                    url: '{{ route('admin.buffalos.sell') }}', // Updated route name
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Optionally, show a success message or redirect to another page
                        // alert('Milk data submitted successfully!');
                        showNotification('info', response.quantity + ' buffalo/s sold');
                        
                        // Clear input fields
                        form.reset();

                        submitBtn.prop('disabled', false);
                        buttonText.show();
                        loadingSpinner.hide();

                        refreshDataTable();

                        // Close the modal
                        var modal = $('#sellBuffalos');
                        modal.modal('hide');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON); // Log the error response
                        alert('Error submitting buffalo data. Please try again.');
                    }
                });
            });
        });
    </script>


    <script>
        let date_created = document.getElementById('date_created')

        date_created.addEventListener('change', (e) => {
            let date_createdVal = e.target.value
            document.getElementById('dateCreatedSelected').innerText = date_createdVal
        });

        let date_sold = document.getElementById('date_sold')

        date_sold.addEventListener('change', (e) => {
            let date_soldVal = e.target.value
            document.getElementById('dateSoldSelected').innerText = date_soldVal
        });
    </script>

@endsection
