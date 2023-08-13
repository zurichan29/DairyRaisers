@extends('layouts.client')
@section('content')
    <!-- Remove Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this address?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                        <span class="loading-spinner" style="display: none;">
                            <span class="spinner-border spinner-border-sm align-middle me-1" aria-hidden="true"></span>
                            <span role="status">Loading...</span>
                        </span>
                        <span class="btn-text"><i class="fa-solid fa-rotate-right"></i>
                            Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Default Confirmation Modal -->
    <div class="modal fade" id="confirmDefaultModal" tabindex="-1" aria-labelledby="confirmDefaultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDefaultModalLabel">Confirm Default</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to set this address as default?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="confirmDefaultBtn">
                        <span class="loading-spinner" style="display: none;">
                            <span class="spinner-border spinner-border-sm align-middle me-1" aria-hidden="true"></span>
                            <span role="status">Loading...</span>
                        </span>
                        <span class="btn-text"><i class="fa-solid fa-rotate-right"></i>
                            Yes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <nav class="" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Address</li>
        </ol>
    </nav>
    <div class="container mb-5">
        <div class="d-flex justify-content-start align-items-center mb-4">
            <a href="{{ route('address.create') }}" class="me-3 btn btn-success"><i class="fa-solid fa-circle-plus"></i>
                Create Address</a>
        </div>


        <div class="">
            <div class="row" id="user-address">
                @if ($addresses->isNotEmpty())
                    @foreach ($addresses as $key => $value)
                        <div class="col">
                            <div class="card shadow d-flex flex-fill h-100">
                                <div class="card-header d-flex justify-content-between align-items-center text-center">
                                    <p class="fw-bold">Address #{{ $key + 1 }}
                                        @if ($value->default == 1)
                                            <span class="ms-2 badge rounded-pill bg-danger">
                                                <span id="cartCount">default</span>
                                        @endif
                                    </p>
                                    <div class="dropdown">
                                        <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                                            <a href="{{ route('address.edit', ['id' => $value->id]) }}"
                                                class="dropdown-item">
                                                Edit
                                            </a>
                                            <buttton type="button" class="dropdown-item default-button"
                                                data-address-id="{{ $value->id }}" data-toggle="modal"
                                                data-target="#confirmDefaultModal">
                                                Set as default
                                            </buttton>
                                            <button type="button" class="dropdown-item remove-button"
                                                data-address-id="{{ $value->id }}" data-toggle="modal"
                                                data-target="#confirmDeleteModal">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>{{ $value->street . ' ' . ucwords(strtolower($value->barangay)) . ', ' . ucwords(strtolower($value->municipality)) . ', ' . ucwords(strtolower($value->province)) . ', ' . $value->zip_code . ' Philippines' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>You have no address yet. Please create in order to make a purchase.</p>
                @endif
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {

            var address_id;

            $(document).on('click', '.remove-button', function() {
                address_id = $(this).data('address-id');
            });

            $('#confirmDeleteBtn').click(function() {
                var submitBtn = $(this);
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                if (address_id) {
                    $.ajax({
                        url: "{{ route('address.delete') }}", // Replace with your route
                        type: "POST",
                        data: {
                            address_id: address_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#user-address').html(response);
                            NotifyUser('info', 'Address update',
                                'User address has been deleted.', false);


                        },
                        error: function(xhr) {
                            console.log(xhr);
                            var errorResponse = xhr.responseJSON;
                            console.log(errorResponse);

                            NotifyUser('error', 'Error',
                                'Something went wrong. Please try again.', false);
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();
                            $('#confirmDeleteModal .btn-secondary').trigger('click');
                        }
                    });
                }
            });

            $(document).on('click', '.default-button', function() {
                address_id = $(this).data('address-id');
                console.log(address_id);
            });

            $('#confirmDefaultBtn').click(function() {
                var submitBtn = $(this);
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                if (address_id) {
                    $.ajax({
                        url: "{{ route('address.default') }}",
                        type: "POST",
                        data: {
                            address_id: address_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#user-address').html(response);
                            NotifyUser('info', 'Address update',
                                'Address has been selected as default.', false);
                            $('#confirmDefaultModal').modal('hide');
                            console.log($('#confirmDefaultModal'));

                        },
                        error: function(xhr) {
                            console.log(xhr);
                            var errorResponse = xhr.responseJSON;
                            console.log(errorResponse);

                            NotifyUser('error', 'Error',
                                'Something went wrong. Please try again.', false);
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();
                            $('#confirmDefaultModal .btn-secondary').trigger('click');
                        }
                    });
                }
            });
        });
    </script>
@endsection
