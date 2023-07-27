@extends('layouts.admin')

@section('content')
    <div class="" style="margin-bottom:2rem; display: flex; gap:9.5rem;">
        <a href="{{asset('admin/buffalos/index')}}" style="background-color:rgb(147, 178, 236); color:white; padding-left:12rem; padding-right:12rem"><i class="fa-solid fa-bottle-water"></i> Milk Stock</a>
        <a href="{{asset('buffalos/update_buffalo')}}" style="background-color:rgb(84, 139, 241); color:white; padding-left:12rem; padding-right:12rem"><i class="fa-solid fa-cow"></i> Buffalos</a>
    </div>
    <!-- Page Heading -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3 text-gray-800">Buffalos</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#updateBuffalos"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
            <span class="text">
                Update Buffalos
            </span>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="updateBuffalos" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Add Buffalo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateBuffalos">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity">
                                <label for="quantity">Quantity of Buffalo</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="date_sold" id="date_sold"
                                    placeholder="Date Sold">
                                <label for="date_sold">Date Sold</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="buyers_name" id="buyers_name"
                                    placeholder="Buyer's Name">
                                <label for="buyers_name">Buyer's Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="buyers_address" id="buyers_address"
                                    placeholder="Buyer's Address">
                                <label for="buyers_address">Buyer's Address</label>
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
                <table class="table table-bordered" id="dataTableB" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ACTIVITY</th>
                            <th>DATE</th>
                            <th>IP ADDRESS</th>
                        </tr>
                    </thead>
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
    <div class="modal fade" id="editBuffalos" tabindex="-1" aria-labelledby="editBuffalosModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBuffalosModalLabel">Edit Buffalos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBuffalosForm" method="POST" action="{{ route('admin.payment_method.update') }}">
                        @csrf
                        <input type="hidden" name="buffalos_id" id="editBuffalosId">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="quantity_sold" id="editQuantitySold"
                                placeholder="QuantitySold">
                            <label for="editQuantitySold">Quantity Sold</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="gender" id="editGender"
                                placeholder="gender">
                            <label for="editGender">Gender</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="age" id="editAge"
                                placeholder="age">
                            <label for="editAge">Age</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="date_sold" id="editdateSold"
                                placeholder="DateSold">
                            <label for="editDateSold">Date Sold</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="buyers_name" id="editBuyersName"
                                placeholder="Buyer's Name">
                            <label for="editBuyersName">Buyer's Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="buyers_address" id="editBuyersAddress"
                                placeholder="Buyer's Address">
                            <label for="editBuyersAddress">Buyer's Address</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    


<script>
    $(document).ready(function() {

        var dataTable = $('#dataTableB').DataTable({
            columns: [
                null, // Activity Log column
                null, // Gender column
                null, // Age column
                null, // Date Sold column
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
            notification.find('.toast-header').removeClass().addClass('toast-header text-white').addClass(
                headerClass);
            notificationBody.text(message);

            // Show the notification with fade-in and fade-out animations
            notification.toast({
                animation: true
            });

            // Show the notification
            notification.toast('show');
        }

        function initializeRowEvents(row) {
            // Edit button click event
            row.find('.edit-btn').click(function() {
                var buffaloId = $(this).data('id');
                var id = row.find('.id-column').text();
                var accountName = row.find('.account-name-column').text();
                var accountNumber = row.find('.account-number-column').text();

                // Populate the form fields with the existing data
                $('#editPaymentMethodId').val(paymentMethodId);
                $('#editType').val(type);
                $('#editAccountName').val(accountName);
                $('#editAccountNumber').val(accountNumber);

                // Store the row data as a data attribute on the form
                $('#updateBuffalo').data('row', row);

                // Show the edit modal
                $('#updateBuffaloModal').modal('show');
            });

            // Status button click event
            row.find('.status-btn').click(function() {
                // ... Your existing status button click event ...
                var statusButton = $(this);
                var buffaloId = statusButton.data('id');
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
                            id: buffaloId,
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
                                'Buffalo status changed.');
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
                var buffaloId = deleteButton.data('id');
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
                            dataTableB.row(row).remove().draw();

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
                url: "{{ route('admin.update_buffalo') }}", // Replace with the desired URL
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

                    $('#dataTableB').DataTable().row.add(newRow).draw();
                    dataTableB.rows().every(function() {
                        initializeRowEvents($(this.node()));
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // Status button click event
        $('.status-btn').click(function() {
            var statusButton = $(this);
            var buffaloId = statusButton.data('id');
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
        });

        // Edit button click event
        $('.edit-btn').click(function() {
            var buffaloId = $(this).data('id');
            var gender = $(this).closest('tr').find('.gender-column').text();
            var age = $(this).closest('tr').find('.age-column').text();
            var date_sold = $(this).closest('tr').find('.date-sold-column').text();
            var buyers_name = $(this).closest('tr').find('.buyers-name-column').text();
            var buyers_address = $(this).closest('tr').find('.buyers-address-column').text();

            // Populate the form fields with the existing data
            $('#editBuffaloId').val(buffaloId);
            $('#editAge').val(age);
            $('#editGender').val(gender);
            $('#editBuyersName').val(buyers_name);
            $('#editBuyersAddress').val(buyers_address);

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

                    var rowData = dataTableB.row(row)
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

                    dataTableB.row(row).data(newData);
                    dataTableB.draw();
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
                        dataTableB.row(row).remove().draw();

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
