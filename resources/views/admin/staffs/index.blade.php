@extends('layouts.admin')

@section('content')
    <!-- Add Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="addStaffModalLabel">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="addStaffForm">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            <label for="name">Name</label>
                            <div id="add-staff-name-error" class="error-container"></div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="email">
                            <label for="email">Email</label>
                            <div id="add-staff-email-error" class="error-container"></div>
                        </div>
                        <div class="px-2 mb-3">
                            <label>Access</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]" value="inventory"
                                            id="access-inventory">
                                        <label class="form-check-label" for="access-inventory">Inventory</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]" value="orders"
                                            id="access-orders">
                                        <label class="form-check-label" for="access-orders">Orders</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]" value="products"
                                            id="access-products">
                                        <label class="form-check-label" for="access-products">Products</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]"
                                            value="payment_methods" id="access-payment_methods">
                                        <label class="form-check-label" for="access-payment_methods">Payment
                                            Methods</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]"
                                            value="buffalos_and_milk" id="access-buffalos_and_milk">
                                        <label class="form-check-label" for="access-buffalos_and_milk">Buffalos and
                                            Milk</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]"
                                            value="staff_management" id="access-staff_management">
                                        <label class="form-check-label" for="access-staff_management">Staff
                                            Management</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="access[]"
                                            value="activity_logs" id="access-activity_logs">
                                        <label class="form-check-label" for="access-activity_logs">Activity
                                            Logs</label>
                                    </div>
                                </div>
                            </div>

                            <div id="add-staff-access-error" class="error-container"></div>
                        </div>

                        <button type="submit" id="addStaffBtn" class="btn btn-primary mb-3">
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
    <!-- Page Heading -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="h3">Staff Management</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#addStaffModal"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
            <span class="text">
                Add Staff
            </span>
        </button>
    </div>
    {{-- Table --}}
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>ACCESS</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $staff)
                                <tr>
                                  <td>{{ $staff->name }}</td>
                                  <td>{{ $staff->email }}</td>
                                  <td>{{ $stafff->access }}</td>
                                  <td>{{ $staff->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var dataTable = null;
            var currentDataTablePage = 1;

            dataTable = $('#dataTable').DataTable();

            $('#addStaffForm').submit(function(e) {
                e.preventDefault();
                var form = this;
                var formObject = $(form).serialize(); // Serialize the form data as a URL-encoded string

                var submitBtn = $(form).find('#addStaffBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

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

                // Perform the AJAX request to add stocks
                $.ajax({
                    url: "{{ route('admin.staff.store') }}",
                    type: "POST",
                    data: formObject, // Use the formObject instead of the formData

                    success: function(response) {
                        console.log(response);
                        // Show success notification
                        showNotification('success', 'Staff Added', response.name +
                            ' added to staff.');

                        // refreshDataTable();

                        // submitBtn.prop('disabled', false);
                        // buttonText.show();
                        // loadingSpinner.hide();

                        form.reset();

                        var modal = $('#addStaffModal');
                        modal.modal('hide');
                    },
                    error: function(xhr) {
                        var errorResponse = xhr.responseJSON;
                        console.log(xhr);
                        if (errorResponse && errorResponse.errors) {
                            // Reset all error divs before showing new errors
                            $('.error-container').html('');

                            // Handle the validation errors
                            var errorFields = Object.keys(errorResponse.errors);

                            errorFields.forEach(function(field) {
                                var errorMessage = errorResponse.errors[field][0];
                                var errorDiv = $('#add-staff-' + field + '-error');

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
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        buttonText.show();
                        loadingSpinner.hide();


                    }
                });
            });
        });
    </script>
@endsection
