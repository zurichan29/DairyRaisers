@extends('layouts.plain')
@section('content')
    {{-- method="POST" action="{{ URL::secure(route('reset_password.verify-new-password', ['token' => $token,  'email' => $email])) }}" --}}
    <form class="container" id="newPasswordForm" style="width: 500px">
        <div class="card shadow">
            <div class="card-header text-center d-flex justify-content-center align-items-center flex-column">
                <img src="{{ asset('images/company-logo.png') }}" class="img-fluid" style="width: 80px" alt="company logo">
                <h5 class="fw-bold">Reset Your Account Password</h5>
                <p>Please enter your new password below to reset your account password. This page is only available for the
                    next 10 minutes for security purposes. If you didn't initiate this request, please disregard this
                    message.</p>
            </div>
            <div class="card-body">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" class="form-control disable-on-submit mb-3" name="password" id="password" required>
                <div id="password-error" class="error-container"></div>
                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control disable-on-submit mb-3" name="password_confirmation"
                    id="password_confirmation" required>
                <div id="password_confirmation-error" class="error-container"></div>
                <button type="submit" id="newPasswordBtn" class="btn btn-primary mb-3">
                    <span class="loading-spinner" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </span>
                    <span class="btn-text">Submit</span>
                </button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#newPasswordForm').submit(function(e) {
                e.preventDefault();
                var form = this;
                var formObject = $(form).serialize(); // Serialize the form data as a URL-encoded string

                var submitBtn = $(form).find('#newPasswordBtn');
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
                    url: "{{ route('reset_password.verify-new-password', ['token' => $token, 'email' => $email]) }}",
                    type: "POST",
                    data: formObject,
                    success: function(response) {
                        if (response.success) {
                            var redirectUrl = "{{ route('login') }}";
                            location.href = redirectUrl;
                        }
                    },
                    error: function(xhr) {
                        var errorResponse = xhr.responseJSON;
                        console.log(xhr);
                        if (errorResponse && errorResponse.errors) {
                            $('.error-container').html('');

                            var errorFields = Object.keys(errorResponse.errors);

                            errorFields.forEach(function(field) {
                                var errorMessage = errorResponse.errors[field][0];
                                var errorDiv = $('#' + field + '-error');

                                errorDiv.html('<p class="text-danger mb-3">' +
                                    errorMessage +
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
        });
    </script>
@endsection
