@extends('layouts.admin')

@section('content')
    {{-- action="{{ route('admin.profile.update-password') }}" method="POST" --}}
    <form id="adminProfileForm" class="container">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                value="{{ $profile->name }}" disabled readonly>
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="email"
                value="{{ $profile->email }}" disabled readonly>
            <label for="email">Email</label>
        </div>
        <div class="">
            <h6>Access:</h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="access-list">
                        @foreach ($accessData as $access)
                            @if ($loop->iteration % 2 !== 0)
                                <li>{{ $access }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="access-list">
                        @foreach ($accessData as $access)
                            @if ($loop->iteration % 2 === 0)
                                <li>{{ $access }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="form-floating mb-3">
            <input id="current_password" type="password" class="form-control" name="current_password"
                placeholder="Current Password" required>
            <label for="current_password">{{ __('Current Password') }}</label>
            <div id="admin-profile-current_password-error" class="error-container"></div>
        </div>

        <div class="form-floating mb-3">
            <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password"
                required>
            <label for="new_password">{{ __('New Password') }}</label>
            <div id="admin-profile-new_password-error" class="error-container"></div>
        </div>

        <div class="form-floating mb-3">
            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation"
                placeholder="New Password Confirmation" required>
            <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
            <div id="admin-profile-new_password_confirmation-error" class="error-container"></div>
        </div>
        <button type="submit" id="adminProfileBtn" class="btn btn-primary mb-3">
            <span class="loading-spinner" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </span>
            <span class="btn-text">Submit</span>
        </button>
    </form>

    <script>
        $(document).ready(function() {
            $('#adminProfileForm').submit(function(e) {
                e.preventDefault();

                var form = this;
                var formObject = $(form).serialize();

                var submitBtn = $(form).find('#adminProfileBtn');
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
                    url: "{{ route('admin.profile.update-password') }}",
                    type: "POST",
                    data: formObject,
                    success: function(response) {
                        $('.error-container').html('');
                        showNotification('success', 'Password Change Successful',
                            'Your password has been successfully changed. Please keep your new password secure.'
                            );

                        form.reset();
                    },
                    error: function(xhr) {
                        var errorResponse = xhr.responseJSON;
                        console.log(xhr);
                        if (errorResponse.password_verification) {
                            showNotification('error', 'Password Verification', errorResponse.password_verification);
                        } else if (errorResponse && errorResponse.errors) {
                            $('.error-container').html('');

                            var errorFields = Object.keys(errorResponse.errors);

                            errorFields.forEach(function(field) {
                                var errorMessage = errorResponse.errors[field][0];
                                var errorDiv = $('#admin-profile-' + field + '-error');

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
        });
    </script>
@endsection
