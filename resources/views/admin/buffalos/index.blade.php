@extends('layouts.admin')

@section('content')
    <div class="" style="margin-bottom:2rem; display: flex; gap:9.5rem;">
        <a href="#" style="background-color:rgb(147, 178, 236); color:white; padding-left:12rem; padding-right:12rem"><i class="fa-solid fa-bottle-water"></i> Milk Stock</a>
        <a href="{{asset('buffalos/update_buffalo')}}" style="background-color:rgb(84, 139, 241); color:white; padding-left:12rem; padding-right:12rem"><i class="fa-solid fa-cow"></i> Buffalos</a>
    </div>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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



    <script>
        $(document).ready(function () {
            // Handle form submission using AJAX
            $('#incrementMilkStockForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission
    
                // Serialize the form data
                var formData = $(this).serialize();
    
                // Send AJAX request
                $.ajax({
                    url: '{{ route('submit.milk_stock') }}', // Updated route name
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        // Optionally, show a success message or redirect to another page
                        alert('Milk data submitted successfully!');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseJSON); // Log the error response
                        alert('Error submitting milk data. Please try again.');
                    }
                });
            });
        });
    </script>
    
    
    <script>
        let date_created = document.getElementById('date_created')
        
        date_created.addEventListener('change',(e)=>{
        let date_createdVal = e.target.value
        document.getElementById('dateCreatedSelected').innerText = date_createdVal
        });
 
    </script>
    
@endsection
