@extends('layouts.login-admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{-- <div class="d-flex justify-content-center align-items-center h-100" style="min-height: 100vh">
        <form class="container" style="width: 500px" id="resetPasswordForm" action="{{ route('login.administrator.reset-password.validate') }}" method="POST">
            @csrf
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control mb-3" id="email" name="email" required>
            <div id="email-error" class="error-container mb-3"></div>
            <button type="submit" id="resetPasswordBtn" class="btn btn-primary mb-3">
                <span class="loading-spinner" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </span>
                <span class="btn-text">Send Password Reset Link</span>
            </button>
        </form>
    </div> --}}

{{-- <script>
        $(document).ready(function() {
            $('#resetPasswordForm').submit(function(e) {
                e.preventDefault();

                var form = this;
                var formData = new FormData(form);

                var submitBtn = $(form).find('#resetPasswordBtn');
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');

                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                $.ajax({
                    url: "{{ route('login.administrator.reset-password.validate') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                     NotifyUser('success', 'Password Reset', 'A password reset link has been sent to your email address.', false);
                    },
                    error: function(xhr) {
                        var errorResponse = xhr.responseJSON;
                        console.log(xhr);
                        if (errorResponse && errorResponse.errors) {
                            $('.error-container').html('');

                            var errorFields = Object.keys(errorResponse.errors);

                            errorFields.forEach(function(field) {
                                var errorMessage = errorResponse.errors[field][0];
                                var errorDiv = $(field + '-error');

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
                    }
                });
            });
        });
    </script> --}}
@endsection
