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
                /* Adjust the font size as per your preference */
            }

            #variantTable {
                font-size: 14px;
            }
        </style>
        <ul class="nav nav-pills nav-fill flex-row mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-inventory-tab" data-bs-toggle="pill" data-bs-target="#pills-inventory"
                    type="button" role="tab" aria-controls="pills-inventory" aria-selected="true"><i
                        class="fa-solid fa-warehouse"></i> Inventory</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-variants-tab" data-bs-toggle="pill" data-bs-target="#pills-variants"
                    type="button" role="tab" aria-controls="pills-variants" aria-selected="false"><i
                        class="fa-solid fa-code-merge"></i> Variants</button>
            </li>
        </ul>
        <div class="tab-content p-2" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-inventory" role="tabpanel"
                aria-labelledby="pills-inventory-tab" tabindex="0">
                <!-- Modal -->
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="addProductModalLabel">Create New Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addProductForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" id="addName"
                                            placeholder="Name">
                                        <label for="addName">Name *</label>
                                        <div id="add-product-name-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="file" class="form-control" name="img" id="addImg"
                                            placeholder="Product Image">
                                        <label for="addImg">Product Image *</label>
                                        <div id="add-product-img-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="variant" id="addVariant">
                                            @foreach ($variants as $variant)
                                                <option value="{{ $variant->name }}">{{ $variant->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="addVariant">Variants *</label>
                                        <div id="add-product-variant-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="price" id="addPrice"
                                            placeholder="Price">
                                        <label for="addPrice">Price *</label>
                                        <div id="add-product-price-error" class="error-container"></div>
                                    </div>
                                    <button type="submit" id="addProductBtn" class="btn btn-primary mb-3">
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
                <!-- Edit Modal -->
                <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editProductForm" method="POST" action="{{ route('admin.products.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" id="editProductId">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" id="editName"
                                            placeholder="Name">
                                        <label for="editName">Name *</label>
                                        <div id="edit-product-name-error" class="error-container"></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="variant" id="editVariant">
                                            @foreach ($variants as $variant)
                                                <option value="{{ $variant->name }}">{{ $variant->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="editVariant">Variants *</label>
                                        <div id="edit-product-variant-error" class="error-container"></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="price" id="editPrice"
                                            placeholder="Price">
                                        <label for="editPrice">Price *</label>
                                        <div id="edit-product-price-error" class="error-container"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="file" class="form-control" name="img" id="editImg"
                                            placeholder="Product Image">
                                        <label for="editImg">Product Image</label>
                                        <div id="edit-product-img-error" class="error-container"></div>
                                    </div>
                                    <button type="submit" id="editProductBtn" class="btn btn-primary mb-3">
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

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="confirmationModalBody">
                                <!-- The confirmation message will be dynamically added here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmActionBtn">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Stocks Modal -->
                <div class="modal fade" id="addStocksModal" tabindex="-1" role="dialog"
                    aria-labelledby="addStocksModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addStocksModalLabel">Add Stocks for <span
                                        id="productName"></span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Current Stock: <span id="currentStock"></span></p>
                                <form id="addStocksForm" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" id="addStocksId">
                                    <div class="mb-3">
                                        <label for="stockQuantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="stockQuantity"
                                            name="stock_quantity" required>
                                        <div id="add-stocks-stock_quantity-error" class="error-container"></div>
                                    </div>
                                    <button type="submit" id="addStocksBtn" class="btn btn-primary mb-3">
                                        <span class="loading-spinner" style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Loading...
                                        </span>
                                        <span class="btn-text">Add Stocks</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addProductModal"
                            class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa-solid fa-circle-plus"></i>
                            </span>
                            <span class="text">
                                Add Product
                            </span>
                        </button>
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" id="copy" class="mr-2 btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-copy"></i> Copy
                            </button>
                            <button type="button" id="downloadExcelButton" class="mr-2 btn btn-sm btn-outline-primary">
                                <i class="fa-regular fa-file-excel"></i> Excel
                            </button>
                            <button type="button" id="printButton" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th class="">NAME</th>
                                        <th class="">VARIANT</th>
                                        <th class="">PRICE</th>
                                        <th class="">STOCKS</th>
                                        <th>STATUS</th>
                                        <th>UPDATED AT</th>
                                        <th class=""></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th class="">NAME</th>
                                        <th class="">VARIANT</th>
                                        <th class="">PRICE</th>
                                        <th class="">STOCKS</th>
                                        <th>STATUS</th>
                                        <th>UPDATED AT</th>
                                        <th class=""></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($products as $product)
                                        @php
                                            $icon = null;
                                            $badge = null;
                                            switch ($product->status) {
                                                case 'AVAILABLE':
                                                    $icon = 'fa-solid fa-circle-check';
                                                    $badge = 'badge-success';
                                                    break;
                                            
                                                case 'NOT AVAILABLE':
                                                    $icon = 'fa-solid fa-circle-xmark';
                                                    $badge = 'badge-danger';
                                                    break;
                                            
                                                default:
                                                    # code...
                                                    break;
                                            }
                                        @endphp
                                        <tr data-product-id="{{ $product->id }}">
                                            <td class="img-column">
                                                <img src="{{ asset($product->img) }}" class="img-fluid img-thumbnail"
                                                    alt="product picture" style="width: 50px; height: 50px;">
                                            </td>
                                            <td class="name-column">{{ $product->name }}</td>
                                            <td class="variant-column">{{ $product->variant->name }}</td>
                                            <td class="price-column">{{ $product->price }}</td>
                                            <td class="stock-column"> {{ $product->stocks }}</td>
                                            <td class="status-column"><span
                                                    class="badge {{ $badge }}">{{ $product->status }} <i
                                                        class="{{ $icon }}"></i></span>
                                            </td>
                                            <td class="update-column">
                                                {{ $product->updated_at }}
                                            </td>
                                            <td class="">
                                                <div class="dropdown">
                                                    <button class="btn rounded-3 btn-light" type="button"
                                                        id="actionsDropdown" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="actionsDropdown">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.products.show', ['id' => $product->id]) }}">View</a>
                                                        <button type="button" class="dropdown-item edit-btn"
                                                            data-product-id="{{ $product->id }}">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="dropdown-item status-btn"
                                                            data-product-id="{{ $product->id }}">{{ $product->status == 'AVAILABLE' ? 'Deactivate' : 'Activate' }}</button>
                                                        <button class="dropdown-item stocks-btn"
                                                            data-product-id="{{ $product->id }}" type="button">Add
                                                            Stocks</button>
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
            <div class="tab-pane fade" id="pills-variants" role="tabpanel" aria-labelledby="pills-variants-tab"
                tabindex="0">

                <!-- Modal -->
                <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="addVariantModalLabel">Create New Variant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addVariantForm">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" id="addName"
                                            placeholder="Name">
                                        <label for="addName">Name</label>
                                        <div id="add-variant-name-error" class="error-container"></div>
                                    </div>
                                    <button type="submit" id="addVariantBtn" class="btn btn-primary mb-3">
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
                <!-- Edit Modal -->
                <div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editVariantLabel">Edit Variant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editVariantForm" method="POST" action="{{ route('admin.variants.update') }}">
                                    @csrf
                                    <input type="hidden" name="variant_id" id="editVariantId">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" id="editVariantName"
                                            placeholder="Name">
                                        <label for="editVariantName">Name</label>
                                        <div id="edit-variant-name-error" class="error-container"></div>
                                    </div>
                                    <button type="submit" id="editVariantBtn" class="btn btn-primary mb-3">
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

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addVariantModal"
                            class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa-solid fa-circle-plus"></i>
                            </span>
                            <span class="text">
                                Add Variants
                            </span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="variantTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="">Name</th>
                                        <th class=""></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="">Name</th>
                                        <th class=""></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($variants as $variant)
                                        <tr data-variant-id="{{ $variant->id }}">
                                            <td class="variant-name-column">{{ $variant->name }}</td>
                                            <td class="">
                                                <div class="dropdown">
                                                    <button class="btn rounded-3 btn-light" type="button"
                                                        id="variantactionsDropdown" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="variantactionsDropdown">
                                                        <button type="button" class="dropdown-item variant-edit-btn"
                                                            data-variant-id="{{ $variant->id }}">
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
                </div>
            </div>
        </div>

        {{-- PRINT, EXCEL, AND COPY SOURCE --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.0.63/print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>

        <script>
            $(document).ready(function() {
                var dataTable = null;
                var currentDataTablePage = 1; // Variable to store the current page number

                function formatDateTime(data) {
                    const dateTime = moment(data, 'YYYY-MM-DD HH:mm:ss');
                    const time = dateTime.format('h:mm A'); // Format time in 12-hour format
                    const date = dateTime.format('M/D/YYYY'); // Format date
                    return time + '<br>' + date; // Separate time and date with a line break (<br>)
                }

                dataTable = $('#dataTable').DataTable({
                    columns: [{
                            className: 'img-column'
                        },
                        {
                            className: 'name-column'
                        },
                        {
                            className: 'variant-column'
                        },
                        {
                            className: 'price-column'
                        },
                        {
                            className: 'stock-column'
                        },
                        {
                            className: 'text-center status-column'
                        },
                        {
                            className: 'update-column',
                            render: function(data, type, row) {
                                return formatDateTime(data);
                            }
                        },
                        null
                    ],
                    // Add a click event listener to the 'status-btn' in the dropdown
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('.status-btn').on('click', function() {
                            var productId = $(this).data('product-id');
                            var productName = $(this).closest('tr').find('.name-column').text();
                            var currentStatus = $(this).text() === 'Activate' ? 'AVAILABLE' :
                                'NOT AVAILABLE';

                            handleStatusButtonClick(productId, productName, currentStatus);
                        });
                    },
                });

                // Initialize Clipboard.js
                new ClipboardJS('#copy', {
                    text: function(trigger) {
                        // Find the datatable
                        var dataTable = $('#dataTable');

                        // Extract and format the datatable data
                        var dataTableData = [];

                        // Include the table header
                        var headerRow = [];
                        dataTable.find('thead th').each(function() {
                            headerRow.push($(this).text());
                        });
                        dataTableData.push(headerRow.join('\t'));

                        // Include the data rows
                        dataTable.find('tbody tr').each(function() {
                            var row = [];
                            $(this).find('td').each(function() {
                                row.push($(this).text());
                            });
                            dataTableData.push(row.join('\t')); // Use tab delimiter for columns
                        });

                        // Include the footer row
                        var footerRow = [];
                        dataTable.find('tfoot th').each(function() {
                            footerRow.push($(this).text());
                        });
                        dataTableData.push(footerRow.join('\t'));

                        return dataTableData.join('\n'); // Use newline delimiter for rows
                    }
                });

                // Handle button click event
                $('#copy').click(function() {
                    showNotification('success', 'Data copied to clipboard!');
                });

                $('#printButton').on('click', function() {
                    if (dataTable.rows().count() > 0) {
                        printJS({
                            printable: 'dataTable', // Provide the ID of the element to print
                            type: 'html', // Specify the type of content
                        });
                    } else {
                        showNotification('error', 'No data to print');
                    }
                });

                // Add event listener for the download button
                $('#downloadExcelButton').on('click', function() {
                    var wb = XLSX.utils.table_to_book(document.getElementById('dataTable'));
                    var wbout = XLSX.write(wb, {
                        bookType: 'xlsx',
                        bookSST: true,
                        type: 'binary'
                    });

                    function s2ab(s) {
                        var buf = new ArrayBuffer(s.length);
                        var view = new Uint8Array(buf);
                        for (var i = 0; i !== s.length; ++i) {
                            view[i] = s.charCodeAt(i) & 0xFF;
                        }
                        return buf;
                    }

                    var blob = new Blob([s2ab(wbout)], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var filename = 'inventory.xlsx'; // You can customize the filename here
                    saveAs(blob, filename);
                });

                // Function to handle the click event of the 'status-btn'
                function handleStatusButtonClick(productId, productName, currentStatus) {
                    var action = currentStatus === 'AVAILABLE' ? 'deactivate' : 'activate';

                    // Show the confirmation modal with the appropriate message
                    var confirmationModal = $('#confirmationModal');
                    var confirmationModalBody = $('#confirmationModalBody');
                    confirmationModalBody.text('Would you like to ' + action + ' the product: ' + productName + '?');
                    confirmationModal.modal('show');

                    // Add a click event listener to the 'Yes' button in the confirmation modal
                    $('#confirmActionBtn').off().on('click', function() {
                        // Close the confirmation modal
                        confirmationModal.modal('hide');

                        // Perform the status update action
                        $.ajax({
                            url: "{{ route('admin.products.updateStatus') }}", // Replace with your route URL for updating the product status
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                productId: productId,
                                currentStatus: currentStatus,
                            },
                            success: function(response) {
                                // Show success notification
                                showNotification('info', ' Product Availability Update', 'The ' +
                                    response.name + ' status has been updated to ' + response
                                    .status + '.');

                                refreshDataTable();
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                // Show error notification
                                showNotification('error', 'Error',
                                    'Something went wrong. Please try again.');
                            }
                        });
                    });
                }

                // Function to initialize DataTable
                function initializeDataTable(data) {
                    dataTable = $('#dataTable').DataTable({ // Store the DataTable instance in the dataTable variable
                        data: data,
                        // Add a click event listener to the 'status-btn' in the dropdown
                        createdRow: function(row, data, dataIndex) {
                            $(row).find('.status-btn').on('click', function() {
                                var productId = data.id;
                                var productName = data.name;
                                var currentStatus = data.status;

                                handleStatusButtonClick(productId, productName, currentStatus);
                            });
                        },
                        columns: [{
                                data: 'img',
                                title: 'PHOTO',
                                className: 'img-column',
                                render: function(data, type, row) {
                                    return '<img src="' + data +
                                        '" class="img-fluid img-thumbnail" alt="product picture" style="width: 50px; height: 50px;">';
                                }
                            },
                            {
                                data: 'name',
                                title: 'NAME',
                                className: 'name-column'
                            },
                            {
                                data: 'variant.name',
                                title: 'VARIANT',
                                className: 'variant-column'
                            },
                            {
                                data: 'price',
                                title: 'PRICE',
                                className: 'price-column'
                            },
                            {
                                data: 'stocks',
                                title: 'STOCKS',
                                className: 'stock-column'
                            },
                            {
                                data: 'status',
                                title: 'STATUS',
                                className: 'text-center status-column',
                                render: function(data, type, row) {
                                    var icon = null;
                                    var badge = null;

                                    switch (data) {
                                        case 'AVAILABLE':
                                            icon = 'fa-solid fa-circle-check';
                                            badge = 'badge-success';
                                            break;

                                        case 'NOT AVAILABLE':
                                            icon = 'fa-solid fa-circle-xmark';
                                            badge = 'badge-danger';
                                            break;

                                        default:
                                            // If the status doesn't match any case, return the status as it is
                                            return data;
                                    }

                                    return '<span class="badge ' + badge + '">' + data + ' <i class="' +
                                        icon + '"></i></span>';
                                }
                            },
                            {
                                data: 'updated_at',
                                title: 'UPDATED AT',
                                className: 'update-column',
                                render: function(data, type, row) {
                                    return formatDateTime(data);
                                }
                            },
                            {
                                data: null,
                                title: '',
                                render: function(data, type, row) {
                                    return '<div class="dropdown">' +
                                        '<button class="btn rounded-3 btn-light" type="button" data-bs-toggle="dropdown" ' +
                                        'aria-haspopup="true" aria-expanded="false">' +
                                        '<i class="fa-solid fa-ellipsis-vertical"></i>' +
                                        '</button>' +
                                        '<div class="dropdown-menu dropdown-menu-end">' +
                                        '<a class="dropdown-item" href="{{ route('admin.products.show', ['id' => ' + data.id + ']) }}">View</a>' +
                                        '<button type="button" class="dropdown-item edit-btn" data-product-id="' +
                                        data.id + '">Edit</button>' +
                                        '<button type="button" class="dropdown-item status-btn" data-product-id="' +
                                        data.id + '">' + (data.status === 'AVAILABLE' ? 'Deactivate' :
                                            'Activate') + '</button>' +
                                        '<button class="dropdown-item stocks-btn" type="button" data-product-id="' +
                                        data.id + '">Add Stocks</button>' +
                                        '</div></div>'; // Added the closing </div> tag here
                                }
                            }
                        ],
                        columnDefs: [{
                            targets: 'img-column',
                            width: '50px',
                            height: '50px',
                        }],
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
                        url: "{{ route('admin.products.data') }}", // Replace with your route URL
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

                // Call the function to initialize DataTable on page load
                // initializeDataTable(@json($products));

                // Event delegation for edit-btn click event
                $(document).on('click', '.edit-btn', function() {
                    var row = $(this).closest('tr');
                    var productId = row.find('.edit-btn').data('product-id');
                    var name = row.find('.name-column').text();
                    var price = row.find('.price-column').text();
                    var variant = row.find('.variant-column').text();

                    // Populate the form fields with the existing data
                    $('#editProductModal').data('row', row); // Store the current row in the modal data
                    $('#editProductId').val(productId);
                    $('#editName').val(name);
                    $('#editPrice').val(price);
                    $('#editVariant').val(variant);

                    // Show the edit modal
                    $('#editProductModal').modal('show');
                });

                $(document).on('click', '.stocks-btn', function() {
                    var row = $(this).closest('tr');
                    var productId = row.find('.stocks-btn').data('product-id');
                    var productName = row.find('.name-column').text();
                    var currentStock = row.find('.stock-column').text();

                    // Set the product name and current stock in the modal
                    $('#addStocksModal').data('row', row);
                    $('#addStocksId').val(productId);
                    $('#productName').text(productName);
                    $('#currentStock').text(currentStock);
                    // Show the modal
                    $('#addStocksModal').modal('show');
                });

                // When the "Add Stocks" button in the modal is clicked, handle the form submission
                $('#addStocksForm').submit(function(e) {
                    e.preventDefault();
                    var form = this;
                    var formData = new FormData(form);
                    // Get the submit button, loading spinner, and button text elements within the form
                    var submitBtn = $(form).find('#addStocksBtn');
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

                    // Perform the AJAX request to add stocks
                    $.ajax({
                        url: "{{ route('admin.products.addStocks') }}",
                        type: "POST",
                        data: {
                            product_id: $('#addStocksId').val(),
                            stock_quantity: $('#stockQuantity').val(),
                        },

                        success: function(response) {

                            // Show success notification
                            showNotification('info', 'Product Stock Update', 'The ' +
                                response.name +
                                '  stock has been increased by ' + response.stock + ' unit(s).');

                            refreshDataTable();

                            // Re-enable the submit button, show the button text, and hide the loading spinner
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            // Clear input fields
                            form.reset();

                            // Close the modal
                            var modal = $('#addStocksModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#add-stocks-' + field + '-error');

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

                // Create Product Form Submit Event
                $('#addProductForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent form submission

                    var form = this;
                    var formData = new FormData(form); // Create FormData object

                    // Get the submit button, loading spinner, and button text elements within the form
                    var submitBtn = $(form).find('#addProductBtn');
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
                        url: "{{ route('admin.products.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                            // Show success notification
                            showNotification('success', 'New Product Added',
                                'A new product has been added successfully.');

                            refreshDataTable();

                            // Re-enable the submit button, show the button text, and hide the loading spinner
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            // Clear input fields
                            form.reset();

                            // Close the modal
                            var modal = $('#addProductModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#add-product-' + field + '-error');

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

                $('#editProductForm').submit(function(e) {
                    e.preventDefault();

                    var row = $('#editProductModal').data('row');
                    var productId = $('#editProductId').val();

                    var form = this;
                    var formData = new FormData(form); // Create FormData object

                    // Get the submit button, loading spinner, and button text elements within the form
                    var submitBtn = $(form).find('#editProductBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    // Disable the submit button and hide the button text, then show the loading spinner
                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    // Perform the AJAX request to update the product and variant
                    $.ajax({
                        url: "{{ route('admin.products.update') }}", // Replace with the desired URL for updating a product
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            showNotification('info', 'Product Update Successful', 'The ' + response[
                                    'name'] +
                                ' details have been updated successfully.');

                            console.log(response);
                            refreshDataTable();

                            // Re-enable the submit button, show the button text, and hide the loading spinner
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            // Close the edit modal
                            $('#editProductModal').modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#edit-product-' + field + '-error');

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



                var variantTable = null;
                var currentVariantTablePage = 1;

                var variantTable = $('#variantTable').DataTable({
                    columns: [{
                            className: 'variant-name-column',
                        },
                        null
                    ]
                });

                // Function to initialize DataTable
                function initializeVariantTable(data) {
                    variantTable = $('#variantTable')
                        .DataTable({ // Store the DataTable instance in the dataTable variable
                            data: data,
                            columns: [{
                                    data: 'name',
                                    title: 'Name',
                                    className: 'variant-name-column'
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
                                            '    <button class="dropdown-item variant-edit-btn" type="button" data-variant-id="' +
                                            data.id + '">Edit</button>' +
                                            '  </div>' +
                                            '</div>'
                                    }
                                }
                            ],
                        });
                }

                function refreshVariantTable() {
                    currentVariantTablePage = variantTable.page.info().page + 1;

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.variants.data') }}", // Replace with your route URL
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Call the function to initialize DataTable with updated data
                            // Destroy the existing DataTable instance before re-initializing with updated data
                            if (variantTable) {
                                variantTable.destroy();
                            }

                            initializeVariantTable(response);

                            variantTable.page(currentVariantTablePage - 1).draw('page');
                        },
                        error: function(xhr) {
                            console.error(xhr);
                        }
                    });
                }

                $(document).on('click', '.variant-edit-btn', function() {
                    var row = $(this).closest('tr');
                    var variantId = row.find('.variant-edit-btn').data('variant-id');
                    var name = row.find('.variant-name-column').text();

                    // Populate the form fields with the existing data
                    $('#editVariantModal').data('row', row); // Store the current row in the modal data
                    $('#editVariantId').val(variantId);
                    $('#editVariantName').val(name);

                    // Show the edit modal
                    $('#editVariantModal').modal('show');
                });

                $('#editVariantForm').submit(function(e) {
                    e.preventDefault();

                    var row = $('#editVariantModal').data('row');
                    var variantId = $('#editVariantId').val();

                    // Get the submit button and loading spinner element
                    var submitBtn = $('#editVariantBtn');
                    var loadingSpinner = submitBtn.find('.loading-spinner');
                    var buttonText = submitBtn.find('.btn-text');

                    // Disable the submit button and show the loading spinner
                    submitBtn.prop('disabled', true);
                    buttonText.hide();
                    loadingSpinner.show();

                    // Perform the AJAX request to update the product and variant
                    $.ajax({
                        url: "{{ route('admin.variants.update') }}", // Replace with the desired URL for updating a product
                        type: 'POST',
                        data: {
                            variant_id: variantId,
                            name: $('#editVariantName').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            // Show success notification
                            showNotification('info', 'Variant Update Successful', 'The ' + response
                                .name +
                                ' details have been updated successfully.');

                            refreshVariantTable();
                            refreshDataTable();

                            // Re-enable the submit button and hide the loading spinner
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();
                            // Close the edit modal
                            $('#editVariantModal').modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#edit-variant-' + field + '-error');

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

                $('#addVariantForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent form submission

                    var form = this;
                    var formData = new FormData(form);

                    // Get the submit button, loading spinner, and button text elements within the form
                    var submitBtn = $(form).find('#addVariantBtn');
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
                        url: "{{ route('admin.variants.store') }}", // Replace with the desired URL for creating a product
                        type: "POST",
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting content type
                        success: function(response) {

                            // Show success notification
                            showNotification('success', 'New Variant Added',
                                'A new variant has been added successfully.');

                            refreshVariantTable();

                            // Update the selection of variants in the addProductModal
                            var newVariantOption = '<option value="' + response.name +
                                '">' + response.name + '</option>';
                            $('#addProductModal').find('#addVariant').append(newVariantOption);
                            $('#editProductModal').find('#editVariant').append(newVariantOption);

                            // Re-enable the submit button, show the button text, and hide the loading spinner
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();

                            // Clear input fields
                            form.reset();

                            // Close the modal
                            var modal = $('#addVariantModal');
                            modal.modal('hide');
                        },
                        error: function(xhr) {
                            var errorResponse = xhr.responseJSON;

                            if (errorResponse && errorResponse.errors) {
                                // Reset all error divs before showing new errors
                                $('.error-container').html('');

                                // Handle the validation errors
                                var errorFields = Object.keys(errorResponse.errors);

                                errorFields.forEach(function(field) {
                                    var errorMessage = errorResponse.errors[field][0];
                                    var errorDiv = $('#add-variant-' + field + '-error');

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
    @endif
@endsection
