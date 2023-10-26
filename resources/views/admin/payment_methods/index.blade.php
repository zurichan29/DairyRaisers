@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <style>
            #dataTable {
                font-size: 14px;
            }
        </style>
        <!-- Modal -->
        <div class="modal fade" id="createPaymentMethod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Create new payment method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createPaymentForm">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="type" id="type" placeholder="Type">
                                <label for="type">Type</label>
                                <div id="add-type-error" class="add-method-error"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="account_name" id="account_name"
                                    placeholder="Account Name">
                                <label for="account_name">Account Name</label>
                                <div id="add-account_name-error" class="add-method-error"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="account_number" id="account_number"
                                    placeholder="Account Number">
                                <label for="account_number">Account Number</label>
                                <div id="add-account_number-error" class="add-method-error"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" name="img" id="addImg"
                                    placeholder="Image">
                                <label for="addImg">Image *</label>
                                <div id="add-img-error" class="error-container"></div>
                            </div>
                            <button type="submit" id="addMethodBtn" class="btn btn-primary mb-3">
                                <span class="loading-spinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </span>
                                <span class="btn-text">Submit</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h1 class="h3 text-primary">Payment Methods</h1>
                <button type="button" data-bs-toggle="modal" data-bs-target="#createPaymentMethod"
                    class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    <span class="text">
                        Create Payment Method
                    </span>
                </button>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TYPE</th>
                                <th>PHOTO</th>
                                <th>ACCOUNT NAME</th>
                                <th>ACCOUNT NO.</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_methods as $method)
                                <tr>
                                    <td class="type-column">{{ $method->type }}</td>
                                    <td class="img-column">
                                        <a href="{{ asset($method->img) }}" data-fancybox="gallery" data-caption="Img">
                                            <img src="{{ asset($method->img) }}" class="img-fluid" style="width: 50px"
                                                alt="Image">
                                        </a>

                                    </td>
                                    <td class="account-name-column">{{ $method->account_name }}</td>
                                    <td class="account-number-column">{{ $method->account_number }}</td>
                                    <td class="text-center">
                                        @if ($method->status == 'ACTIVATED')
                                            <p class="badge bg-success text-center text-wrap status-badge"
                                                style="width: 6rem;">
                                                {{ $method->status }}
                                            </p>
                                        @else
                                            <p class="badge bg-danger text-center text-wrap status-badge"
                                                style="width: 6rem;">
                                                {{ $method->status }}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="actionsDropdown">
                                                <button type="button" class="dropdown-item edit-btn"
                                                    data-id="{{ $method->id }}">Edit</button>

                                                <button type="button" class="dropdown-item status-btn"
                                                    data-id="{{ $method->id }}">{{ $method->status == 'ACTIVATED' ? 'Deactivate payment method' : 'Activate payment method' }}</button>
                                                <hr class="dropdown-divider">
                                                <button type="button" class="dropdown-item delete-btn"
                                                    data-id="{{ $method->id }}">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

        <!-- Edit Modal -->
        <div class="modal fade" id="editPaymentMethodModal" tabindex="-1" aria-labelledby="editPaymentMethodModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPaymentMethodForm" method="POST"
                            action="{{ route('admin.payment_method.update') }}">
                            @csrf
                            <input type="hidden" name="payment_method_id" id="editPaymentMethodId">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="type" id="editType"
                                    placeholder="Type">
                                <label for="editType">Type</label>
                                <div id="edit-type-error" class="edit-method-error"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="account_name" id="editAccountName"
                                    placeholder="Account Name">
                                <label for="editAccountName">Account Name</label>
                                <div id="edit-account_name-error" class="edit-method-error"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="account_number" id="editAccountNumber"
                                    placeholder="Account Number">
                                <label for="editAccountNumber">Account Number</label>
                                <div id="edit-account_number-error" class="edit-method-error"></div>
                            </div>
                            <button type="submit" id="updateMethodBtn" class="btn btn-primary mb-3">
                                <span class="loading-spinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </span>
                                <span class="btn-text">Save Changes</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $("[data-fancybox]").fancybox({
                    thumbs: {
                        autoStart: true,
                        axis: 'x'
                    },
                    buttons: [
                        'zoom',
                        'slideShow',
                        'fullScreen',
                        'close'
                    ]
                });
                var dataTable = null;
                var currentDataTablePage = 1;
                dataTable = $('#dataTable').DataTable({
                    columns: [{
                            className: 'type-column',
                        },
                        {
                            className: 'img-column',
                        },
                        {
                            className: 'account-name-column',
                        },
                        {
                            className: 'account-number-column',
                        },
                        { // Status column
                            className: 'text-center',
                        },
                        { // Actions column
                            className: 'text-center',
                            orderable: false, // Disable sorting for the actions column
                        }
                    ],
                });

                function clearErrorMessages() {
                    $('.add-method-error').empty();
                    $('.edit-method-error').empty();
                }

                // Function to initialize DataTable
                function initializeDataTable(data) {
                    console.log(data);
                    dataTable = $('#dataTable').DataTable({ // Store the DataTable instance in the dataTable variable
                        data: data,
                        columns: [{
                                data: 'type',
                                title: 'TYPE',
                                className: 'type-column'
                            },
                            {
                                data: 'img',
                                title: 'PHOTO',
                                className: 'img-column',
                                render: function(data, type, row) {
                                    var assetUrl = "{{ asset('') }}" + data;
                                    console.log(assetUrl);
                                    
                                    return  `<a href="${assetUrl}" data-fancybox="gallery" data-caption="Img">
                                            <img src="${assetUrl}" class="img-fluid" style="width: 50px"
                                                alt="Image">
                                        </a>`;
                                }
                            },
                            {
                                data: 'account_name',
                                title: 'ACCOUNT NAME',
                                className: 'account-name-column'
                            },
                            {
                                data: 'account_number',
                                title: 'ACCOUNT NO.',
                                className: 'account-number-column'
                            },
                            {
                                data: 'status',
                                title: 'STATUS',
                                className: 'text-center',
                                render: function(data, type, row) {
                                    var statusBadge = data === 'ACTIVATED' ?
                                        '<p class="badge bg-success text-wrap status-badge" style="width: 6rem;">ACTIVATED</p>' :
                                        '<p class="badge bg-danger text-wrap status-badge" style="width: 6rem;">DEACTIVATED</p>';

                                    return statusBadge;
                                }
                            },
                            {
                                data: null,
                                title: '',
                                className: 'text-center',
                                render: function(data, type, row) {
                                    var statusBadge = data.status == 'ACTIVATED' ?
                                        '<p class="badge bg-success text-wrap status-badge" style="width: 6rem;">ACTIVATED</p>' :
                                        '<p class="badge bg-danger text-wrap status-badge" style="width: 6rem;">DEACTIVATED</p>';

                                    return `
                            <div class="dropdown">
                                <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                                    <button type="button" class="dropdown-item edit-btn" data-id="${data.id}">Edit</button>
                                    <button type="button" class="dropdown-item status-btn" data-id="${data.id}">${data.status === 'ACTIVATED' ? 'Deactivate payment method' : 'Activate payment method'}</button>
                                    <hr class="dropdown-divider">
                                    <button type="button" class="dropdown-item delete-btn" data-id="${data.id}">Delete</button>
                                </div>
                            </div>
                        `;
                                }
                            }
                        ]
                    });
                }

                // Function to fetch updated data and refresh DataTable
                function refreshDataTable() {
                    // Save the current page number before refreshing the table
                    currentDataTablePage = dataTable.page.info().page + 1;
                    // Get the CSRF token value
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.payment_method.data') }}", // Replace with your route URL
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Call the function to initialize DataTable with updated data
                            // Destroy the existing DataTable instance before re-initializing with updated data
                            if (dataTable) {
                                dataTable.destroy();
                            }
                            console.log(response);
                            console.log(response.status);
                            initializeDataTable(response);

                            // Restore the current page after the table is refreshed
                            dataTable.page(currentDataTablePage - 1).draw('page');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                function initializeRowEvents(row) {
                    // Edit button click event
                    row.find('.edit-btn').click(function() {
                        var paymentMethodId = $(this).data('id');
                        var type = row.find('.type-column').text();
                        var accountName = row.find('.account-name-column').text();
                        var accountNumber = row.find('.account-number-column').text();

                        // Populate the form fields with the existing data
                        $('#editPaymentMethodId').val(paymentMethodId);
                        $('#editType').val(type);
                        $('#editAccountName').val(accountName);
                        $('#editAccountNumber').val(accountNumber);

                        // Store the row data as a data attribute on the form
                        $('#editPaymentMethodForm').data('row', row);

                        // Show the edit modal
                        $('#editPaymentMethodModal').modal('show');
                    });

                    // Status button click event
                    row.find('.status-btn').click(function() {
                        // ... Your existing status button click event ...
                        var statusButton = $(this);
                        var paymentMethodId = statusButton.data('id');
                        var confirmationMessage = '';

                        // Determine the new status based on the current status
                        var currentStatus = statusButton.closest('tr').find('.status-badge').text().trim();
                        var newStatus = '';
                        var newBg = '';
                        if (currentStatus === 'ACTIVATED') {
                            newStatus = 'DEACTIVATED';
                            confirmationMessage = 'Do you want to deactivate this payment method?';
                            newBg = 'bg-danger';
                        } else {
                            newStatus = 'ACTIVATED';
                            confirmationMessage = 'Do you want to activate this payment method?';
                            newBg = 'bg-success';
                        }

                        showConfirmationModal(confirmationMessage, function() {
                            // Proceed with updating the payment method status
                            $.ajax({
                                url: '{{ route('admin.payment_method.status') }}', // Replace with the actual URL for updating the payment method status
                                type: 'POST',
                                data: {
                                    id: paymentMethodId,
                                    status: newStatus,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    // Update the status button text
                                    statusButton.text((newStatus === 'ACTIVATED') ?
                                        'Deactivate payment method' :
                                        'Activate payment method');

                                    // Update the status badge
                                    var statusBadge = statusButton.closest('tr').find(
                                        '.status-badge');
                                    statusBadge.removeClass('bg-success bg-danger');
                                    statusBadge.addClass(newBg);
                                    statusBadge.text(newStatus);

                                    // Show notification
                                    showNotification('updated',
                                        'Payment Method status changed.');
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        });
                        // Same as before...
                    });

                    // Delete button click event
                    row.find('.delete-btn').click(function() {
                        // ... Your existing delete button click event ...
                        var deleteButton = $(this);
                        var paymentMethodId = deleteButton.data('id');
                        var confirmationMessage = "Are you sure? You won't be able to revert this!";

                        showConfirmationModal(confirmationMessage, function() {
                            // Proceed with deleting the payment method
                            $.ajax({
                                url: '{{ route('admin.payment_method.delete') }}', // Replace with the actual URL for deleting the payment method
                                type: 'POST',
                                data: {
                                    id: paymentMethodId,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    // Remove the row from the table
                                    var row = deleteButton.closest('tr');
                                    dataTable.row(row).remove().draw();

                                    // Show notification
                                    showNotification('deleted', 'Payment Method deleted.');
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        });
                        // Same as before...
                    });
                }

                $('#createPaymentForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent form submission
                    var form = this;
                    var formData = new FormData(this); // Create FormData object

                    // Get the submit button, loading spinner, and button text elements within the form
                    var submitBtn = $(this).find('#addMethodBtn');
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

                    $.ajax({
                        url: "{{ route('admin.payment_method.store') }}", // Replace with the desired URL
                        type: "POST",
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting content type
                        success: function(response) {
                            // Show success notification
                            showNotification('success', 'Payment Method Added', response.type +
                                'payment successfully addded.');

                            // Clear input fields
                            form.reset();

                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            refreshDataTable();

                            // Close the modal
                            var modal = $('#createPaymentMethod');
                            modal.modal('hide');

                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.add-method-error').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#add-' + field + '-error');

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

                // Status button click event
                $(document).on('click', '.status-btn', function() {
                    var statusButton = $(this);
                    var paymentMethodId = statusButton.data('id');
                    var confirmationMessage = '';

                    // Determine the new status based on the current status
                    var currentStatus = statusButton.closest('tr').find('.status-badge').text().trim();
                    var newStatus = '';
                    var newBg = '';
                    if (currentStatus === 'ACTIVATED') {
                        newStatus = 'DEACTIVATED';
                        confirmationMessage = 'Do you want to deactivate this payment method?';
                        newBg = 'bg-danger';
                    } else {
                        newStatus = 'ACTIVATED';
                        confirmationMessage = 'Do you want to activate this payment method?';
                        newBg = 'bg-success';
                    }


                    showConfirmationModal(confirmationMessage, function() {
                        // Proceed with updating the payment method status
                        $.ajax({
                            url: '{{ route('admin.payment_method.status') }}', // Replace with the actual URL for updating the payment method status
                            type: 'POST',
                            data: {
                                id: paymentMethodId,
                                status: newStatus,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                // Update the status button text
                                statusButton.text((newStatus === 'ACTIVATED') ?
                                    'Deactivate payment method' :
                                    'Activate payment method');

                                refreshDataTable();

                                // Show notification
                                showNotification('info', 'Payment Method status changed',
                                    response.type +
                                    ' status changed to ' + response.status + '.');
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    });
                });

                // Edit button click event
                $(document).on('click', '.edit-btn', function() {
                    var paymentMethodId = $(this).data('id');
                    var type = $(this).closest('tr').find('.type-column').text();
                    var accountName = $(this).closest('tr').find('.account-name-column').text();
                    var accountNumber = $(this).closest('tr').find('.account-number-column').text();
                    // Populate the form fields with the existing data
                    $('#editPaymentMethodId').val(paymentMethodId);
                    $('#editType').val(type);
                    $('#editAccountName').val(accountName);
                    $('#editAccountNumber').val(accountNumber);

                    // Store the row data as a data attribute on the form
                    var row = $(this).closest('tr');
                    $('#editPaymentMethodForm').data('row', row);

                    // Show the edit modal
                    $('#editPaymentMethodModal').modal('show');
                });

                // Edit form submit event
                $('#editPaymentMethodForm').on('submit', function(e) {
                    e.preventDefault();
                    var row = $(this).data('row');
                    var form = this;
                    var formData = new FormData(this);
                    // Get the submit button, loading spinner, and button text elements within the form
                    var submitBtn = $(this).find('#updateMethodBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    // Disable the submit button and hide the button text, then show the loading spinner
                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();
                    // Perform the AJAX request to update the payment method
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            // Show success notification
                            showNotification('info', 'Payment Method update', response.type +
                                ' updated successfully.');

                            // Clear input fields
                            form.reset();

                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            refreshDataTable();

                            // Close the edit modal
                            $('#editPaymentMethodModal').modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.edit-method-error').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#edit-' + field + '-error');

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

                /// Delete button click event
                $(document).on('click', '.delete-btn', function() {
                    var deleteButton = $(this);
                    var paymentMethodId = deleteButton.data('id');
                    var confirmationMessage = "Are you sure? You won't be able to revert this!";

                    showConfirmationModal(confirmationMessage, function() {
                        // Proceed with deleting the payment method
                        $.ajax({
                            url: '{{ route('admin.payment_method.delete') }}', // Replace with the actual URL for deleting the payment method
                            type: 'POST',
                            data: {
                                id: paymentMethodId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                // Remove the row from the table
                                // var row = deleteButton.closest('tr');
                                // dataTable.row(row).remove().draw();
                                // Show notification
                                showNotification('error', 'Payment Method deleted', response
                                    .type + ' deleted.');

                                refreshDataTable();

                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    });
                });

                // Show the confirmation modal with custom message and execute the callback on confirmation
                function showConfirmationModal(message, callback) {
                    var confirmationModal = $('#confirmationModal');
                    var confirmationMessage = $('#confirmationMessage');
                    confirmationMessage.text(message);
                    confirmationModal.modal('show');

                    $('#confirmActionBtn').off('click').on('click', function() {
                        callback();
                        confirmationModal.modal('hide');
                    });
                }
            });
        </script>
    @endif
@endsection
