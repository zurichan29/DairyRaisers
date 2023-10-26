@extends('layouts.admin')
@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h1 class="h3 text-primary">Manage Delivery Fees</h1>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>MUNICIPALITY</th>
                                <th>FEE</th>
                                <th>DATE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delivery_fees as $fee)
                                <tr>
                                    <td>{{ $fee->municipality }}</td>
                                    <td>₱{{ $fee->fee }}.00</td>
                                    <td>{{ $fee->updated_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                                                <button type="button" class="dropdown-item edit-btn"
                                                    data-fee-id="{{ $fee->id }}"
                                                    data-name-id="{{ $fee->municipality }}">
                                                    Edit
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editDeliveryFee" tabindex="-1" aria-labelledby="editDeliveryFeeLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDeliveryFeeLabel">Edit Delivery Fee: <span
                                    id="delivery_fee_municipality"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editDeliveryFeeForm" method="POST" action="#">
                                @csrf
                                <input type="hidden" name="fee_id" id="editDeliveryFeeId">

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="fee" id="editFee"
                                        placeholder="Name">
                                    <label for="editFee">Fee: </label>
                                    <div id="edit-fee-error" class="error-container"></div>
                                </div>
                                <button type="submit" id="editDeliveryFeeBtn" class="btn btn-primary mb-3">
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
        </div>

        <script>
            $(document).ready(function() {
                var dataTable = null;
                var currentDataTablePage = 1;

                function formatDateTime(data) {
                    const dateTime = moment(data, 'YYYY-MM-DD HH:mm:ss');
                    const time = dateTime.format('h:mm A');
                    const date = dateTime.format('M/D/YYYY');
                    return time + '<br>' + date;
                }

                dataTable = $('#dataTable').DataTable({
                    columns: [{
                            className: 'municipality-column'
                        },
                        {
                            className: 'fee-column'
                        },
                        {
                            className: 'date-column',
                            render: function(data, type, row) {
                                return formatDateTime(data);
                            }
                        },
                        null
                    ],

                });

                function initializeDataTable(data) {
                    dataTable = $('#dataTable').DataTable({
                        data: data,
                        columns: [{
                                data: 'municipality',
                                title: 'MUNICIPALITY',
                                className: 'municipality-column'
                            },
                            {
                                data: 'fee',
                                title: 'FEE',
                                className: 'fee-column',
                                render: function(data, type, row) {
                                    return `₱${data}.00`;
                                }
                            },
                            {
                                data: 'updated_at',
                                title: 'DATE',
                                className: 'date-column',
                                render: function(data, type, row) {
                                    return formatDateTime(data);
                                }
                            },
                            {
                                data: null,
                                title: '',
                                render: function(data, type, row) {
                                    return '<div class="dropdown">' +
                                        '  <button class="btn rounded-3 btn-light" type="button" id="variantactionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                        '    <i class="fa-solid fa-ellipsis-vertical"></i>' +
                                        '  </button>' +
                                        '  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="variantactionsDropdown">' +
                                        '    <button class="dropdown-item edit-btn" type="button" data-fee-id="' +
                                        data.id + '" data-name-id="' + data.municipality + '">Edit</button>' +
                                        '  </div>' +
                                        '</div>'
                                }
                            }
                        ]
                    });
                };

                function refreshDataTable() {
                    currentDataTablePage = dataTable.page.info().page + 1;
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.delivery_fee.data') }}",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (dataTable) {
                                dataTable.destroy();
                            }
                            initializeDataTable(response);
                            dataTable.page(currentDataTablePage - 1).draw('page');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                };

                $(document).on('click', '.edit-btn', async function() {
                    var row = $(this).closest('tr');
                    var DeliveryFeeId = row.find('.edit-btn').data('fee-id');
                    var Municipality = row.find('.edit-btn').data('name-id');

                    $.ajax({
                        url: "{{ route('admin.delivery_fee.get-municipality') }}",
                        type: 'POST',
                        data: {
                            fee_id: DeliveryFeeId,
                            fee: $('#editFee').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            $('#editDeliveryFee').data('row', row);
                            $('#editDeliveryFeeId').val(DeliveryFeeId);
                            $('#editFee').val(response.fee);
                            $('#delivery_fee_municipality').text(response.municipality);

                            $('#editDeliveryFee').modal('show');
                            console.log(DeliveryFeeId, Municipality);
                        },
                        error: function(xhr) {

                        }
                    });



                });

                $('#editDeliveryFeeForm').submit(function(e) {
                    e.preventDefault();

                    var row = $('#editDeliveryFee').data('row');
                    var DeliveryFeeId = $('#editDeliveryFeeId').val();

                    var submitBtn = $('#editDeliveryFeeBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    $.ajax({
                        url: "{{ route('admin.delivery_fee.update') }}",
                        type: 'POST',
                        data: {
                            fee_id: DeliveryFeeId,
                            fee: $('#editFee').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            showNotification('info', 'Delivery Fee Updated', 'The ' + response
                                .municipality +
                                ' delivery fee have been updated successfully.');

                            refreshDataTable();

                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            $('#editDeliveryFee').modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                $('.error-container').html('');
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#edit-' + field + '-error');
                                    errorDiv.html('<p class="text-danger">' + errorMessage +
                                        '</p>');
                                });
                            } else {
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
    @endif
@endsection
