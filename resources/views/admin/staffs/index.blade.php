@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        @php
            $halfCount = ceil(count($accessList) / 2);
            $firstHalf = array_slice($accessList, 0, $halfCount);
            $secondHalf = array_slice($accessList, $halfCount);
        @endphp
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
                                <input type="text" class="form-control disable-on-submit" name="name" id="name"
                                    placeholder="Name">
                                <label for="name">Name</label>
                                <div id="add-staff-name-error" class="error-container"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control disable-on-submit" name="email" id="email"
                                    placeholder="email">
                                <label for="email">Email</label>
                                <div id="add-staff-email-error" class="error-container"></div>
                            </div>
                            <div class="px-2 mb-3">
                                <label>Access</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul>
                                            @foreach ($firstHalf as $access)
                                                <li>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input disable-on-submit"
                                                            name="access[]" value="{{ $access }}"
                                                            id="access-{{ $access }}">
                                                        <label class="form-check-label"
                                                            for="access-{{ $access }}">{{ $access }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul>
                                            @foreach ($secondHalf as $access)
                                                <li>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="access[]"
                                                            value="{{ $access }}" id="access-{{ $access }}">
                                                        <label class="form-check-label"
                                                            for="access-{{ $access }}">{{ $access }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
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
        <!-- Edit Modal -->
        <div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStaffLabel">Edit Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editStaffForm" method="POST" action="">
                            @csrf
                            <input type="hidden" name="staff_id" id="editStaffId">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control disable-on-submit" name="name" id="editName"
                                    placeholder="Name">
                                <label for="editName">Name *</label>
                                <div id="edit-staff-name-error" class="error-container"></div>
                            </div>

                            <div class="px-2 mb-3">
                                <label>Access</label>
                                <div class="row">
                                    <div class="col-md-6" id="access-col-1">
                                        <!-- Access options for column 1 go here -->
                                    </div>
                                    <div class="col-md-6" id="access-col-2">
                                        <!-- Access options for column 2 go here -->
                                    </div>
                                </div>
                                <div id="edit-staff-access-error" class="error-container"></div>
                            </div>

                            <button type="submit" id="editStaffBtn" class="btn btn-primary mb-3">
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
        {{-- Table --}}
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 text-primary">Staff Management</h1>
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
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>ACCESS</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $staff)
                                @if (!$staff->is_admin)
                                    @php
                                        $access = is_array($staff->access) ? $staff->access : json_decode($staff->access, true);
                                        if ($staff->is_verified) {
                                            $badge = 'success';
                                            $text = 'VERIFIED';
                                        } else {
                                            $badge = 'danger';
                                            $text = 'NOT VERIFIED';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->email }} </td>
                                        <td>
                                            @if (is_array($access))
                                                <ul>
                                                    @foreach ($access as $permission)
                                                        <li>{{ $permission }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-{{ $badge }}">{{ $text }}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn rounded-3 btn-light" type="button"
                                                    id="actionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="actionsDropdown">
                                                    <button type="button" class="dropdown-item edit-btn"
                                                        data-staff-id="{{ $staff->id }}">
                                                        Edit
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var dataTable = null;
                var currentDataTablePage = 1;

                dataTable = $('#dataTable').DataTable();

                function initializeDataTable(data) {
                    dataTable = $('#dataTable').DataTable({
                        data: data,
                        columns: [{
                                data: 'name',
                                title: 'NAME'
                            },
                            {
                                data: 'email',
                                title: 'EMAIL',
                                render: function(data, type, row) {
                                    var badgeClass = row.is_verified ? 'badge bg-success' :
                                        'badge bg-danger';
                                    var badgeText = row.is_verified ? 'VERIFIED' : 'NOT VERIFIED';
                                    return `${data} <span class="${badgeClass}">${badgeText}</span>`;
                                }
                            },
                            {
                                data: 'access',
                                title: 'ACCESS',
                                render: function(data, type, row) {
                                    var accessList = Array.isArray(data) ? data : JSON.parse(data);
                                    var accessHtml = '<ul>';
                                    accessList.forEach(function(permission) {
                                        accessHtml += `<li>${permission}</li>`;
                                    });
                                    accessHtml += '</ul>';
                                    return accessHtml;
                                }
                            },
                            {
                                data: null,
                                title: 'STATUS',
                                render: function(data, type, row) {
                                    // Return an empty string for the "Status" column
                                    return '';
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `<div class="dropdown">
                            <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                                <button type="button" class="dropdown-item edit-btn" data-staff-id="${row.id}">
                                    Edit
                                </button>
                            </div>
                        </div>`;
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
                        url: "{{ route('admin.staff.init') }}", // Replace with your route URL
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Call the function to initialize DataTable with updated data
                            // Destroy the existing DataTable instance before re-initializing with updated data
                            if (dataTable) {
                                dataTable.destroy();
                            }

                            initializeDataTable(response);

                            // Restore the current page after the table is refreshed
                            dataTable.page(currentDataTablePage - 1).draw('page');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }

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

                    // Disable form inputs with class "disable-on-submit"
                    $(form).find('.disable-on-submit').prop('disabled', true);

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

                            refreshDataTable();

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

                            // Enable form inputs with class "disable-on-submit"
                            $(form).find('.disable-on-submit').prop('disabled', false);
                        }
                    });
                });

                $(document).on('click', '.edit-btn', function() {

                    var staffId = $(this).closest('tr').find('.edit-btn').data('staff-id');

                    $.ajax({
                        url: "{{ route('admin.staff.fetch') }}", // Replace with the desired URL for updating a product
                        type: 'POST',
                        data: {
                            staff_id: staffId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            var staff = response.staff;
                            var staffAccess = response.staffAccess;

                            $('#editStaffId').val(staff.id);
                            $('#editName').val(staff.name);
                            // ACCESS DATA GOES HERE TO PUT ON THE EDIT MODAL

                            // Clear the existing access options
                            $('#access-col-1').html('');
                            $('#access-col-2').html('');

                            // Function to generate the HTML for access options
                            function generateAccessHtml(accessList, columnId) {
                                var accessHtml = '';
                                $.each(accessList, function(index, access) {
                                    var isChecked = staffAccess.includes(access) ?
                                        'checked' : '';
                                    accessHtml += `<div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="access[]" value="${access}" id="access-${access}-${columnId}" ${isChecked}>
                                            <label class="form-check-label" for="access-${access}-${columnId}">${access}</label>
                                        </div>`;
                                });
                                return accessHtml;
                            }

                            // Append the access options to the corresponding columns
                            $('#access-col-1').html(generateAccessHtml(@json($firstHalf),
                                '1'));
                            $('#access-col-2').html(generateAccessHtml(@json($secondHalf),
                                '2'));

                            $('#editStaffModal').modal('show');
                        },
                        error: function(error) {
                            console.error(error.responseJSON.message);
                        }
                    });
                });

                $('#editStaffForm').submit(function(e) {
                    e.preventDefault();

                    var form = this;
                    var formData = new FormData(form);

                    var submitBtn = $(form).find('#editStaffBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    $.ajax({
                        url: "{{ route('admin.staff.update') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            showNotification('info', 'Staff Updated', response['name'] +
                                ' has updated successfully.');

                            refreshDataTable();

                            // Close the edit modal
                            $('#editStaffModal').modal('hide');
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
                                    var errorDiv = $('#edit-staff-' + field + '-error');

                                    // Display the error message in the respective error div
                                    errorDiv.html('<p class="text-danger">' + errorMessage +
                                        '</p>');
                                });
                            } else {
                                // Handle other error cases
                                console.error(xhr.responseText);
                            }
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
    @endif
@endsection
