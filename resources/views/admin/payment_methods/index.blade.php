@extends('layouts.admin')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Payment Methods</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#createPaymentMethod"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
            <span class="text">
                Create Payment Method
            </span>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="createPaymentMethod" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
                                <input type="text" class="form-control" name="type" id="type"
                                    placeholder="Type">
                                <label for="type">Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="account_name" id="account_name"
                                    placeholder="Account Name">
                                <label for="account_name">Account Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="account_number" id="account_number"
                                    placeholder="Account Number">
                                <label for="account_number">Account Number</label>
                            </div>
                            <button type="submit" class="btn float-end btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Account Name</th>
                            <th>Account No.</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Type</th>
                            <th>Account Name</th>
                            <th>Account No.</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($payment_methods as $method)
                            <tr>
                                <td class="type-column">{{ $method->type }}</td>
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
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
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
                    <form id="editPaymentMethodForm" method="POST" action="{{ route('admin.payment_method.update') }}">
                        @csrf
                        <input type="hidden" name="payment_method_id" id="editPaymentMethodId">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="type" id="editType"
                                placeholder="Type">
                            <label for="editType">Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="account_name" id="editAccountName"
                                placeholder="Account Name">
                            <label for="editAccountName">Account Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="account_number" id="editAccountNumber"
                                placeholder="Account Number">
                            <label for="editAccountNumber">Account Number</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   

    <script>
        $(document).ready(function() {

            var dataTable = $('#dataTable').DataTable({
                columns: [
                    null, // Type column
                    null, // Account Name column
                    null, // Account Number column
                    { // Status column
                        className: 'text-center',
                    },
                    { // Actions column
                        className: 'text-center',
                        orderable: false, // Disable sorting for the actions column
                    }
                ],
            });

            function showNotification(status, message) {
                var notification = $('#Notification');
                var notificationHeader = notification.find('.toast-header');
                var notificationBody = notification.find('.toast-body');
                var iconClass = '';
                var headerClass = '';
                var headerText = '';
    
                // Update classes, icon, and header text based on the status
                switch (status) {
                    case 'success':
                        headerClass = 'bg-success';
                        iconClass = 'fa-solid fa-circle-check';
                        headerText = 'Success';
                        break;
                    case 'updated':
                        headerClass = 'bg-info';
                        iconClass = 'fa-solid fa-circle-info';
                        headerText = 'Updated';
                        break;
                    case 'deleted':
                        headerClass = 'bg-warning';
                        iconClass = 'fa-solid fa-trash';
                        headerText = 'Deleted';
                        break;
                    case 'error':
                        headerClass = 'bg-danger';
                        iconClass = 'fa-solid fa-circle-xmark';
                        headerText = 'Error';
                        break;
                    default:
                        break;
                }
    
                // Update the notification content and classes
                notificationHeader.find('strong').removeClass().addClass('me-auto').html(
                    '<i class="me-2 fa-solid ' + iconClass + '"></i> ' + headerText);
                notification.find('.toast-header').removeClass().addClass('toast-header text-white').addClass(headerClass);
                notificationBody.text(message);
    
                // Show the notification with fade-in and fade-out animations
                notification.toast({
                    animation: true
                });
    
                // Show the notification
                notification.toast('show');
            }
            
            $('#createPaymentForm').submit(function(e) {
                e.preventDefault(); // Prevent form submission

                var formData = new FormData(this); // Create FormData object

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
                        // Clear input fields
                        $('#createPaymentForm')[0].reset();

                        // Close the modal
                        var modal = $('#createPaymentMethod');
                        modal.modal('hide');

                        // Show success notification
                        showNotification('success', 'Payment Method successfully addded.');

                        // Add new row to DataTable
                        var newRow = [
                            response.type,
                            response.account_name,
                            response.account_number,
                            '<p class="badge bg-success text-center text-wrap" style="width: 6rem;">' +
                            response.status +
                            '</p>',
                            '<div class="dropdown">' +
                            '  <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '    <i class="fa-solid fa-ellipsis-vertical"></i>' +
                            '  </button>' +
                            '  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">' +
                            '    <a class="dropdown-item" href="#">Edit</a>' +
                            '    <a class="dropdown-item status-btn" href="#" data-id="' +
                            response.id + '">Deactivate</a>' +
                            '    <hr class="dropdown-divider">' +
                            '    <a class="dropdown-item delete-btn" href="#" data-id="' +
                            response.id + '">Delete</a>' +
                            '  </div>' +
                            '</div>'
                        ];

                        $('#dataTable').DataTable().row.add(newRow).draw();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            // Status button click event
            $('.status-btn').click(function() {
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
                            showNotification('updated', 'Payment Method status changed.');
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                });
            });

            // Edit button click event
            $('.edit-btn').click(function() {
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
            $('#editPaymentMethodForm').submit(function(e) {
                e.preventDefault();
                var row = $(this).data('row');
                // Perform the AJAX request to update the payment method
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Close the edit modal
                        $('#editPaymentMethodModal').modal('hide');

                        // Show success notification
                        showNotification('updated', ' Payment method updated successfully.');

                        // Update the corresponding row in the table
                        var paymentMethodId = response.id;

                        var rowData = dataTable.row(row)
                            .data(); // Get the data for the selected row

                        var newData = [
                            response.type,
                            response.account_name,
                            response.account_number,
                            '<p class="badge ' + ((response.status === 'ACTIVATED') ?
                                'bg-success' : 'bg-danger'
                            ) +
                            ' text-center text-wrap status-badge" style="width: 6rem;">' +
                            response.status + '</p>',
                            '<div class="dropdown">' +
                            '  <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '    <i class="fa-solid fa-ellipsis-vertical"></i>' +
                            '  </button>' +
                            '  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">' +
                            '    <a class="dropdown-item edit-btn" href="#" data-id="' +
                            paymentMethodId + '">Edit</a>' +
                            '    <a class="dropdown-item status-btn" href="#" data-id="' +
                            paymentMethodId + '">' +
                            '      ' + ((response.status === 'ACTIVATED') ?
                                'Deactivate payment method' : 'Activate payment method'
                            ) + '' +
                            '    </a>' +
                            '    <hr class="dropdown-divider">' +
                            '    <a class="dropdown-item delete-btn" href="#" data-id="' +
                            paymentMethodId + '">Delete</a>' +
                            '  </div>' +
                            '</div>'
                        ];

                        dataTable.row(row).data(newData);
                        dataTable.draw();
                    },
                    error: function(error) {
                        console.error(error.responseJSON.message);
                    }
                });
            });


            /// Delete button click event
            $('.delete-btn').click(function() {
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
   
@endsection
