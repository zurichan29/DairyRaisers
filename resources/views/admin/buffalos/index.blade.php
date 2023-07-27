@extends('layouts.admin')

@section('content')
    {{-- NAV PILLS --}}
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
    {{-- CONTENT OF NAV PILLS --}}
    <div class="tab-content p-2" id="pills-tabContent">
        {{-- CONTENT 1 --}}
        <div class="tab-pane fade show active" id="pills-inventory" role="tabpanel" aria-labelledby="pills-inventory-tab"
            tabindex="0">
            <!-- Page Heading -->
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <h1 class="h3 text-gray-800">Milk Stocks</h1>
                <button type="button" data-bs-toggle="modal" data-bs-target="#incrementMilkStock"
                    class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    <span class="text">
                        Update Milk Stocks
                    </span>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="incrementMilkStock" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
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
                                        <label for="quantity">Quantity</label>
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
            <div class="modal fade" id="editMilkStockModal" tabindex="-1" aria-labelledby="editMilkStockModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ediMilkStockModalLabel">Edit Milk Stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editMilkStockForm" method="POST" action="">
                                @csrf
                                <input type="hidden" name="milk_stock_id" id="editMilkStockId">
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
                                    <label for="quantity">Quantity</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- CONTENT 2 --}}
        <div class="tab-pane fade" id="pills-variants" role="tabpanel" aria-labelledby="pills-variants-tab"
            tabindex="0">
        </div>
    </div>




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

                // Get the CSRF token value
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the AJAX request headers
                    }
                });
                // Send AJAX request
                $.ajax({
                    url: '{{ route('submit.milk_stock') }}', // Updated route name
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        // Optionally, show a success message or redirect to another page
                        // alert('Milk data submitted successfully!');
                        showNotification('info', 'Milk Stocks Updated', 'Milk Stock updated to ' + response.quantity);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON); // Log the error response
                        alert('Error submitting milk data. Please try again.');
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
    </script>
@endsection
