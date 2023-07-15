@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <div class="container ml-[23rem] my-16 bg-[#deb88757] text-center items-center justify-center p-8 rounded-[1rem] shadow-[0_.5rem_1rem_rgba(0,0,0,0.6)]"
        style="max-width: 550px">
        <div class="alert alert-danger" id="error" style="display: none;"></div>
        <h3 class="mb-5 text-[#5f9ea0] font-semibold text-2xl">Add Phone Number</h3>
        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
        <form>
            <label class="text-[#5f9ea0] text-lg font-semibold">Phone Number:</label>
            <input type="text" id="number" class="form-control py-1 px-2 rounded text-[#5f9ea0] font-semibold"
                placeholder="+91 ********">
            <div id="recaptcha-container" class=" ml-20 mt-4"></div>
            <button type="button"
                class="btn btn-primary mt-3 bg-[#199696] w-fit py-2 px-5 text-white font-bold rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300"
                onclick="sendOTP();">Send OTP</button>
        </form>

        <div class="mb-5 mt-16">
            <h3 class="mb-2 text-[#5f9ea0] font-semibold text-2xl">Add verification code</h3>
            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
            <form>
                <input type="text" id="verification" class="form-control py-1 px-2 rounded text-[#5f9ea0] font-semibold"
                    placeholder="Verification code">
                <button type="button"
                    class="btn btn-danger mt-3 bg-[#199696] w-fit py-2 px-4 text-white font-bold text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300"
                    onclick="verify()">Verify code</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyB3nzcqfcg6hKAjtg6SWHxwIr4h_4AtPXo",
            authDomain: "dairy-raisers.firebaseapp.com",
            projectId: "dairy-raisers",
            storageBucket: "dairy-raisers.appspot.com",
            messagingSenderId: "1068745368281",
            appId: "1:1068745368281:web:c766aab3bb26ecd56e94c8",
            measurementId: "G-40W54BYGR2"
        };
        firebase.initializeApp(firebaseConfig);

        let verificationCode = null;
        let resendTimer = null;
        let resendCount = 0;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('form').submit(function() {
            return false;
        });

        function sendOTP() {
            const pattern = /^9[0-9]{9}$/;
            var number = $("#number").val();

            if (pattern.test(number)) {
                number = '+63' + number;

                $.ajax({
                    url: "/check-reset-password-form",
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    data: {
                        number: number
                    },
                    success: function(response) {
                        if (response.status === 'userError') {
                            // Mobile number already exists
                            console.log(response.user);
                            $("#error").text("This number is not yet registered");
                            $("#error").show();
                        } else if (response.status === 'verified') {
                            if (!window.recaptchaVerifier || !$("#recaptcha-container").children().length) {
                                // Regenerate the reCAPTCHA widget
                                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
                                    'recaptcha-container');
                                recaptchaVerifier.render();
                            }

                            const appVerifier = window.recaptchaVerifier;
                            firebase.auth().signInWithPhoneNumber(number, appVerifier)
                                .then(function(confirmationResult) {
                                    window.confirmationResult = confirmationResult;
                                    coderesult = confirmationResult;
                                    console.log(coderesult);
                                    $("#successAuth").text("Message sent");
                                    $("#successAuth").show();
                                })
                                .catch(function(error) {
                                    console.log(error);
                                    $("#error").text(error.message);
                                    $("#error").show();
                                });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        $("#error").text("Error occurred");
                        $("#error").show();
                    }
                });
            } else {
                $("#error").text("Invalid number format");
                $("#error").show();
            }
        }



        function verify() {
            var code = $("#verification").val();
            coderesult.confirm(code)
                .then(function(result) {
                    var user = result.user;
                    console.log(user);
                    $("#successOtpAuth").text("Auth is successful");
                    $("#successOtpAuth").show();

                    // Get the verified mobile number
                    var verifiedNumber = $("#number").val();

                    // Input to database
                    $.ajax({
                        url: "/verify-reset-password-form",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        data: {
                            number: verifiedNumber
                        },
                        success: function(response) {

                            if (response.status == 'success') {
                                // Redirect to the register details page with the mobile number as a query parameter
                                window.location.href = "/reset-password/" + verifiedNumber;
                            } else if (response.status == 'failed') {
                                $("#error").text("Error occurred");
                                $("#error").show();
                            }


                        },
                        error: function(error) {
                            console.log(error);
                            $("#error").text("Error occurred");
                            $("#error").show();
                        }
                    });

                })
                .catch(function(error) {
                    $("#error").text(error.message);
                    $("#error").show();
                });
        }

        function resendOTP() {
            // Increase the resend count
            resendCount++;

            const number = $("#number").val();
            const appVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            firebase.auth().signInWithPhoneNumber(number, appVerifier)
                .then(function(confirmationResult) {
                    verificationCode = confirmationResult;
                    $("#successAuth").text("Message sent");
                    $("#successAuth").show();

                    // Disable the resend button and start the resend timer
                    $("#resendButton").prop("disabled", true);
                    startResendTimer();
                })
                .catch(function(error) {
                    console.log(error);
                    $("#error").text(error.message);
                    $("#error").show();
                });
        }

        function startResendTimer() {
            // Disable the resend button for 60 seconds
            const resendButton = $("#resendButton");
            resendButton.prop("disabled", true);

            // Start the timer
            let secondsLeft = 60;
            resendTimer = setInterval(function() {
                if (secondsLeft > 0) {
                    secondsLeft--;
                    resendButton.text("Resend Code (" + secondsLeft + "s)");
                } else {
                    clearInterval(resendTimer);
                    resendButton.text("Resend Code");
                    resendButton.prop("disabled", false);
                }
            }, 1000);
        }

        // Call the function to initialize reCAPTCHA on page load
        $(document).ready(function() {
            render();
        });

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
    </script>

    @include('client.components.footer')
@endsection
