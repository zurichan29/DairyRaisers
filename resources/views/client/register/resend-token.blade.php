@extends('layouts.client')

@section('content')
    <form class="mb-3 container" id="resendTokenForm">
        @csrf
        <p class="mb-3">Kindly enter your email address to resend another verification mail.</p>
        <div class="input-group has-validation mb-3">
            <span class="input-group-text">@</span>
            <div class="form-floating">
                <input type="email" class="form-control disable-on-submit" id="email" name="email"
                    placeholder="Username" required>
                <label for="email">Email *</label>
            </div>
            <div id="resend-token-email-error" class="error-container"></div>
        </div>
        <div class="text-success" id="message"></div>
        <button type="submit" id="resendTokenBtn" class="btn btn-primary mb-3">
            <span class="loading-spinner" style="display: none">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </span>
            <span class="btn-text">Submit</span>
        </button>
        <div id="timer" style="display: none;"></div>
    </form>

    <script>
        $(document).ready(function() {
            let countdownTime = 60;

            function startTimer() {
                $('#resendTokenBtn').prop('disabled', true);
                $('#timer').text(`Resend in ${countdownTime} seconds`);
                $('#timer').show();

                const interval = setInterval(() => {
                    countdownTime--;
                    $('#timer').text(`Resend in ${countdownTime} seconds`);

                    if (countdownTime === 0) {
                        clearInterval(interval);
                        $('#timer').hide();
                        $('#resendTokenBtn').prop('disabled', false);
                        countdownTime = 60;
                    }
                }, 1000);
            }
           

            $('#resendTokenForm').submit(function(e) {
                e.preventDefault();
                var form = this;
                var formObject = $(form).serialize();

                var submitBtn = $(form).find('#resendTokenBtn');
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
                    url: "{{ route('register.resend-token.send') }}",
                    type: "POST",
                    data: formObject,
                    success: function(response) {
                        console.log(response);
                        NotifyUser('success', 'Verification Sent', response.success);

                    },
                    error: function(xhr) {
                        var errorResponse = xhr.responseJSON;
                        $('.error-container').html('');

                        if (errorResponse.error) {
                            var errorDiv = $('#resend-token-email-error');


                            NotifyUser('error', errorResponse.error);

                        } else if (errorResponse && errorResponse.errors) {
                            var errorFields = Object.keys(errorResponse.errors);

                            errorFields.forEach(function(field) {
                                var errorMessage = errorResponse.errors[field][0];
                                var errorDiv = $('#resend-token-' + field + '-error');

                                // errorDiv.html('<p class="text-danger">' + errorMessage +
                                //     '</p>');

                                NotifyUser('error', errorMessage);
                            });
                        } else {
                            console.error(xhr.responseText);
                        }
                    },
                    complete: function() {
                        setTimeout(function() {
                            submitBtn.prop('disabled', false);
                            buttonText.show();
                            loadingSpinner.hide();
                            $(form).find('.disable-on-submit').prop('disabled', false);

                            startTimer();
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endsection
