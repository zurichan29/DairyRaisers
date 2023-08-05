@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <!-- Page Heading -->
        <div class="row">
            <div class="col ">
                <div class="row ">
                    <div class="col d-grid">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#updateBuffaloModal"
                            class=" btn btn-sm btn-primary btn-icon-split" id="update-buffalo-show">
                            <span class="icon text-white-50">
                                <i class="fa-solid fa-arrow-rotate-right"></i>
                            </span>
                            <span class="text">
                                Update
                            </span>
                        </button>
                    </div>

                    <div class="col d-grid">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#sellBuffaloModal"
                            class="btn btn-sm btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa-solid fa-tag"></i>
                            </span>
                            <span class="text">
                                Sell
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="mt-3 card border-left-primary shadow h-100">
                            <div class="card-body pb-0">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                            Buffalos</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="buffaloCount">
                                            {{ $buffaloCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-cow fa-3x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="mt-3 card border-left-primary shadow h-100">
                            <div class="card-body pb-0">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Baby
                                            Male</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="babyMaleCount">
                                            {{ $babyMaleCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mt-3 card border-left-primary shadow h-100">
                            <div class="card-body pb-0">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Baby
                                            Female</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="babyFemaleCount">
                                            {{ $babyFemaleCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mt-3 card border-left-primary shadow h-100">
                            <div class="card-body pb-0">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Adult
                                            Male</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="adultMaleCount">
                                            {{ $adultMaleCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mt-3 card border-left-primary shadow h-100">
                            <div class="card-body pb-0">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Adult
                                            Female</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="adultFemaleCount">
                                            {{ $adultFemaleCount }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>BUFFALO INVOICE</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" id="buffaloInvoiceTable" width="100%"
                                style="font-size: 13px" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>
                                        <th>QTY</th>
                                        <th>TOTAL</th>
                                        <th>DATE</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buffalo_sales as $sales)
                                        <tr>
                                            <td>{{ $sales->buyer_name }}</td>
                                            <td>{{ $sales->buyer_address }}</td>
                                            <td>{{ $sales->total_quantity }}</td>
                                            <td>₱{{ $sales->grand_total }}</td>
                                            <td>{{ date('Y-m-d', strtotime($sales->created_at)) }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm rounded-3 btn-light" type="button"
                                                        id="actionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="actionsDropdown">
                                                        <a href="{{ route('admin.dairy.buffalo-show', ['id' => $sales->id]) }}"
                                                            class="dropdown-item">View</a>
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
            </div>
        </div>

        {{-- UPDATE MODAL --}}
        <div class="modal fade" id="updateBuffaloModal" tabindex="-1" aria-labelledby="updateBuffaloModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="updateBuffaloModalLabel">Update Buffalo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="updateBuffaloForm">
                            @csrf
                            <div class="col">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="male_baby">Male Baby:</label>
                                        <input type="number" class="form-control disable-on-submit" name="male_baby"
                                            id="male_baby">
                                        <div id="update-buffalo-male_baby-error" class="error-container"></div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="female_baby">Female Baby:</label>
                                        <input type="number" class="form-control disable-on-submit" name="female_baby"
                                            id="female_baby">
                                        <div id="update-buffalo-female_baby-error" class="error-container"></div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="male_adult">Male Adult:</label>
                                        <input type="number" class="form-control disable-on-submit" name="male_adult"
                                            id="male_adult">
                                        <div id="update-buffalo-male_adult-error" class="error-container"></div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="female_adult">Female Adult:</label>
                                        <input type="number" class="form-control disable-on-submit" name="female_adult"
                                            id="female_adult">
                                        <div id="update-buffalo-female_adult-error" class="error-container"></div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="updateBuffaloBtn" class="btn btn-primary mb-3">
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

        {{-- SELL MODAL --}}
        <div class="modal fade" id="sellBuffaloModal" tabindex="-1" aria-labelledby="sellBuffaloModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="sellBuffaloModalLabel">Sell a Buffalo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="sellBuffaloForm">
                            @csrf
                            <div id="sell-buffalo-stock-error"></div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control disable-on-submit" name="buyer_name"
                                    id="buyer_name" placeholder="buyer name">
                                <label class="">Buyer Name:</label>
                                <div id="sell-buffalo-buyer_name-error" class="error-container text-danger"></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control disable-on-submit" name="buyer_address"
                                    id="buyer_address" placeholder="buyer address">
                                <label class="">Buyer Address:</label>
                                <div id="sell-buffalo-buyer_address-error" class="error-container text-danger">
                                </div>
                            </div>

                            <div id="sell-buffalo-detail-error" class="text-danger"></div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Gender</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Age</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Quantity</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Price</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Total</label>
                                </div>
                            </div>

                            <div id="categoriesContainer">
                                <div class="category row mb-3">
                                    <div class="col">
                                        <label>Male</label>
                                        <input type="hidden" name="categories[0][gender]" value="male">
                                    </div>
                                    <div class="col">
                                        <label>Baby</label>
                                        <input type="hidden" name="categories[0][age]" value="baby">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control quantity disable-on-submit"
                                            name="categories[0][quantity]" value="1">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control price disable-on-submit"
                                            name="categories[0][price]">
                                    </div>
                                    <div class="col">
                                        <span class="total">0</span>
                                    </div>
                                </div>
                                <div class="category row mb-3">
                                    <div class="col">
                                        <label>Female</label>
                                        <input type="hidden" name="categories[1][gender]" value="female">
                                    </div>
                                    <div class="col">
                                        <label>Baby</label>
                                        <input type="hidden" name="categories[1][age]" value="baby">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control quantity disable-on-submit"
                                            name="categories[1][quantity]" value="1">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control price disable-on-submit"
                                            name="categories[1][price]">
                                    </div>
                                    <div class="col">
                                        <span class="total">0</span>
                                    </div>
                                </div>
                                <div class="category row mb-3">
                                    <div class="col">
                                        <label>Male</label>
                                        <input type="hidden" name="categories[2][gender]" value="male">
                                    </div>
                                    <div class="col">
                                        <label>Adult</label>
                                        <input type="hidden" name="categories[2][age]" value="adult">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control quantity disable-on-submit"
                                            name="categories[2][quantity]" value="1">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control price disable-on-submit"
                                            name="categories[2][price]">
                                    </div>
                                    <div class="col">
                                        <span class="total">0</span>
                                    </div>
                                </div>
                                <div class="category row mb-3">
                                    <div class="col">
                                        <label>Female</label>
                                        <input type="hidden" name="categories[3][gender]" value="female">
                                    </div>
                                    <div class="col">
                                        <label>Adult</label>
                                        <input type="hidden" name="categories[3][age]" value="adult">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control quantity disable-on-submit"
                                            name="categories[3][quantity]" value="1">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control price disable-on-submit"
                                            name="categories[3][price]">
                                    </div>
                                    <div class="col">
                                        <span class="total">0</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Display the grand total -->
                            <div class="row mb-3">
                                <div class="col text-end">
                                    <label class="form-label">Grand Total:</label>
                                </div>
                                <div class="col">
                                    <span id="grandTotal">0.00</span>
                                </div>
                            </div>

                            <button type="submit" id="sellBuffaloBtn" class="btn btn-primary mb-3">
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

        <script>
            $(document).ready(function() {

            });
        </script>

        <script>
            function calculateTotal() {
                var grandTotal = 0;

                $('.category').each(function() {
                    var quantity = $(this).find('.quantity').val();
                    var price = $(this).find('.price').val();
                    var total = parseFloat(quantity) * parseFloat(price);

                    if (!isNaN(total)) {
                        $(this).find('.total').text('₱' + total.toFixed(2));
                        grandTotal += total;
                    } else {
                        $(this).find('.total').text('₱0.00');
                    }
                });

                $('#grandTotal').text('₱' + grandTotal.toFixed(2));
            }

            $(document).ready(function() {
                var buffaloInvoiceTable = null;
                var currentbuffaloInvoiceTablePage = 1;
                buffaloInvoiceTable = $('#buffaloInvoiceTable').DataTable();

                function initializeBuffaloInvoiceTable(data) {
                    buffaloInvoiceTable = $('#buffaloInvoiceTable').DataTable({
                        data: data,
                        columns: [{
                                data: 'buyer_name',
                                title: 'NAME'
                            },
                            {
                                data: 'buyer_address',
                                title: 'ADDRESS'
                            },
                            {
                                data: 'total_quantity',
                                title: 'QTY'
                            },
                            {
                                data: 'grand_total',
                                title: 'TOTAL',
                                render: $.fn.dataTable.render.number(',', '.', 2, '₱')
                            },
                            {
                                data: 'created_at',
                                title: 'DATE',
                                render: function(data, type, row) {
                                    return moment(data).format('YYYY-MM-DD');
                                }
                            },
                            {
                                data: null,
                                title: '',
                                render: function(data, type, row) {
                                    return '<div class="dropdown">' +
                                        '<button class="btn btn-sm rounded-3 btn-light" type="button" id="actionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                        '<i class="fa-solid fa-ellipsis-vertical"></i>' +
                                        '</button>' +
                                        '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">' +
                                        '<a href="' +
                                        '{{ route('admin.dairy.buffalo-show', ['id' => ':id']) }}'
                                        .replace(':id', row.id) + '" class="dropdown-item">View</a>' +
                                        '</div>' +
                                        '</div>';
                                }
                            }
                        ]
                    });
                }

                function refreshBuffaloInvoiceTable() {

                    currentbuffaloInvoiceTablePage = buffaloInvoiceTable.page.info().page + 1;

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.dairy.buffalo-sales-fetch') }}", // Replace with your route URL
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {

                            if (buffaloInvoiceTable) {
                                buffaloInvoiceTable.destroy();
                            }

                            initializeBuffaloInvoiceTable(response);

                            buffaloInvoiceTable.page(currentbuffaloInvoiceTablePage - 1).draw('page');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                $(document).on('click', '#update-buffalo-show', function() {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.dairy.buffalo-fetch') }}", // Replace with your route URL
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#male_baby').val(response[0].quantity);
                            $('#male_adult').val(response[1].quantity);
                            $('#female_baby').val(response[2].quantity);
                            $('#female_adult').val(response[3].quantity);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                });

                $('#updateBuffaloForm').submit(function(e) {
                    e.preventDefault();
                    var form = this;
                    var formObject = $(form).serialize();

                    var submitBtn = $(form).find('#updateBuffaloBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    $(form).find('.disable-on-submit').prop('disabled', true);

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.dairy.buffalo-update') }}",
                        type: "POST",
                        data: formObject,
                        success: function(response) {
                            showNotification('success', 'Buffalo Update', response.success);

                            $('#babyMaleCount').text(response.counts.baby_male);
                            $('#babyFemaleCount').text(response.counts.baby_female);
                            $('#adultMaleCount').text(response.counts.adult_male);
                            $('#adultFemaleCount').text(response.counts.adult_female);
                            $('#buffaloCount').text(response.counts.total);

                            form.reset();
                            var modal = $('#updateBuffaloModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;
                            console.log(xhr);
                            if (errorResponse && errorResponse.errors) {
                                $('.error-container').html('');

                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#update-buffalo-' + field + '-error');

                                    errorDiv.html('<p class="text-danger">' + errorMessage +
                                        '</p>');
                                });
                            } else {
                                console.error(xhr.responseText);
                            }
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            $(form).find('.disable-on-submit').prop('disabled', false);
                        }
                    });
                });

                calculateTotal();
                $('.quantity, .price').on('input', function() {
                    calculateTotal();
                });

                $('#sellBuffaloForm').submit(function(e) {
                    e.preventDefault();
                    var form = this;
                    var formObject = $(form).serialize();

                    var submitBtn = $(form).find('#sellBuffaloBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    $(form).find('.disable-on-submit').prop('disabled', true);

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.dairy.buffalo-sell') }}",
                        type: "POST",
                        data: formObject,
                        success: function(response) {
                            showNotification('success', 'Buffalo Sold', response.success);

                            $('#babyMaleCount').text(response.counts.baby_male);
                            $('#babyFemaleCount').text(response.counts.baby_female);
                            $('#adultMaleCount').text(response.counts.adult_male);
                            $('#adultFemaleCount').text(response.counts.adult_female);
                            $('#buffaloCount').text(response.counts.total);

                            refreshBuffaloInvoiceTable();

                            form.reset();
                            var modal = $('#sellBuffaloModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;
                            $('#sell-buffalo-detail-error').html('');
                            $('.error-container').html('');
                            console.log(errorResponse.errors);
                            if (errorResponse.errors || errorResponse.stock) {



                                if (errorResponse.errors) {
                                    var categoriesErrors = Object.keys(errorResponse.errors).filter(
                                        function(key) {
                                            return key.startsWith('categories');
                                        });

                                    if (errorResponse.errors.buyer_name) {
                                        $('#sell-buffalo-buyer_name-error').html(errorResponse
                                            .errors.buyer_name[0]);
                                    }
                                    if (errorResponse.errors.buyer_address) {
                                        $('#sell-buffalo-buyer_address-error').html(errorResponse
                                            .errors.buyer_address[0]);
                                    }
                                    if (categoriesErrors.length > 0) {
                                        $('#sell-buffalo-detail-error').html(
                                            'All values are empty. Please input aleast 1 row value of quantity and price.'
                                        );
                                    }
                                } else if (errorResponse.stock) {
                                    $('#sell-buffalo-detail-error').html(xhr.responseJSON.stock);
                                } else if (errorResponse.stock) {
                                    console.log('stock');

                                }

                            } else {
                                console.error(xhr.responseText);
                            }
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            $(form).find('.disable-on-submit').prop('disabled', false);
                        }
                    });
                });
            });
        </script>
    @endif
@endsection
