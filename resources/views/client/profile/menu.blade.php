@extends('layouts.client')
@section('content')
    <div class="container pt-3 pb-5 mb-5">
        <div class="row">
            <div class="col">
                <div class="card shadow d-flex flex-fill h-100">
                    <div class="card-body">
                        <form id="editProfileForm">
                            @csrf
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control disable-on-submit" name="first_name"
                                        id="first_name" value="{{ auth()->user()->first_name }}" required>
                                    <div id="edit-profile-first_name-error" class="error-container"></div>
                                </div>
                                <div class="col">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control disable-on-submit" name="last_name"
                                        id="last_name" value="{{ auth()->user()->last_name }}" required>
                                    <div id="edit-profile-last_name-error" class="error-container"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="mobile_number" class="form-label">Mobile No. *</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">+63</span>
                                    <input type="text" class="form-control disable-on-submit" name="mobile_number"
                                        id="mobile_number" value="{{ auth()->user()->mobile_number }}" required>
                                </div>
                                <div id="edit-profile-mobile_number-error" class="error-container"></div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" id="editProfileBtn">
                                    <span class="loading-spinner" style="display: none;">
                                        <span class="spinner-border spinner-border-sm align-middle me-1"
                                            aria-hidden="true"></span>
                                        <span role="status">Loading...</span>
                                    </span>
                                    <span class="btn-text"><i class="fa-solid fa-rotate-right"></i>
                                        Change</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="card shadow d-flex flex-fill h-100">
                    <div class="card-header">
                        <p class="bg-primary rounded text-white p-3 fs-3">
                            <span class="fw-lighter fs-6">Email Address:</span><br>
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                    <div class="card-body ">
                        <div class="d-flex justify-content-between align-items-center text-center h-100">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('profile.address') }}"><i
                                    class="fa-solid fa-map-location"></i> Address</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('profile.change_password') }}"><i
                                    class="fa-solid fa-rotate-right"></i> Change password</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('logout') }}"><i
                                    class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#editProfileForm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                var formObject = $(form).serialize();

                var submitBtn = $(form).find('#editProfileBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                $(form).find('.disable-on-submit').prop('disabled', true);
                $('.error-container').html('');

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: "{{ route('profile.edit') }}",
                    type: "POST",
                    data: formObject,
                    success: function(response) {
                        NotifyUser('info', 'Profile update',
                            'Your profile has been successfully updated.', false);
                        console.log(response);
                            $('#user-name').html(response);
                    },
                    error: function(xhr) {
                        var errorResponse = xhr.responseJSON;
                        if (errorResponse && errorResponse.errors) {
                            $('.error-container').html('');

                            var errorFields = Object.keys(errorResponse.errors);

                            errorFields.forEach(function(field) {
                                var errorMessage = errorResponse.errors[field][0];
                                var errorDiv = $('#edit-profile-' + field + '-error');

                                errorDiv.html('<p class="text-danger">' + errorMessage +
                                    '</p>');
                            });

                            $('#first_name').val(errorResponse.user.first_name);
                            $('#last_name').val(errorResponse.user.last_name);
                            $('#mobile_number').val(errorResponse.user.mobile_number);

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








    {{-- <ul class="nav nav-pills nav-fill flex-row mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                type="button" role="tab" aria-controls="pills-profile" aria-selected="true"><i
                    class="fa-solid fa-user-tie"></i> Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill" data-bs-target="#pills-address"
                type="button" role="tab" aria-controls="pills-address" aria-selected="false"><i
                    class="fa-solid fa-location-dot"></i> Address</button>
        </li>
    </ul>

    <div class="tab-content p-2 mb-5 pb-5" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
            tabindex="0">
            <div class="row">
                <div class="col">

                </div>
                <div class="col">
                    
                </div>
            </div>
         
        </div>

        <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab" tabindex="0">
        </div>

        
    </div> --}}
@endsection
