<x-layout>
    @include('client.components.header')
    {{-- <form method="POST" action="{{ URL::secure(route('register.validate')) }}">
        @csrf
        <label for="mobile_number">Enter Mobile Number:</label>
        <input type="number" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}">
        @error('mobile_number')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">submit</button>
    </form> --}}

    {{-- <div class="container mt-5" style="max-width: 550px">
        <div class="alert alert-danger" id="error" style="display: none;"></div>
        <h3>Add Phone Number</h3>
        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
        <form>
            <label>Phone Number:</label>
            <input type="text" id="number" class="form-control" placeholder="+91 ********">
            <div id="recaptcha-container"></div>
            <button type="button" class="btn btn-primary mt-3" onclick="sendOTP();">Send OTP</button>
        </form>

        <div class="mb-5 mt-5">
            <h3>Add verification code</h3>
            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
            <form>
                <input type="text" id="verification" class="form-control" placeholder="Verification code">
                <button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
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
    </script>
    <script type="text/javascript">
        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        function sendOTP() {
            var number = $("#number").val();
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                $("#successAuth").text("Message sent");
                $("#successAuth").show();
            }).catch(function(error) {
                console.log(error);
                $("#error").text(error.message);
                $("#error").show();
            });
        }

        function verify() {
            var code = $("#verification").val();
            coderesult.confirm(code).then(function(result) {
                var user = result.user;
                console.log(user);
                $("#successOtpAuth").text("Auth is successful");
                $("#successOtpAuth").show();
            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    </script> --}}

    <div class="container mt-5" style="max-width: 550px">
        <div class="alert alert-danger" id="error" style="display: none;"></div>
        <h3>Add Phone Number</h3>
        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
        <form>
            <label>Phone Number:</label>
            <input type="text" id="number" class="form-control" placeholder="+91 ********">
            <div id="recaptcha-container"></div>
            <button type="button" class="btn btn-primary mt-3" onclick="sendOTP();">Send OTP</button>
        </form>

        <div class="mb-5 mt-5">
            <h3>Add verification code</h3>
            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
            <form>
                <input type="text" id="verification" class="form-control" placeholder="Verification code">
                <button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
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

        function sendOTP() {
            const number = $("#number").val();

            // Perform a request to check if the mobile number already exists in your database
            $.ajax({
                url: "/check-mobile-number",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    number: number
                },
                success: function(response) {
                    if (response.status === 'verified') {
                        // Mobile number already exists
                        $("#error").text("Mobile number already registered");
                        $("#error").show();
                    } else if (response.status === 'no data') {
                        window.location.href = "/register-details/number/" + encodeURIComponent(number);
                    } else if (response.status === 'unverified') {
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
                        url: "/input-mobile-number",
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
                                window.location.href = "/register-details/number/" + encodeURIComponent(
                                    verifiedNumber);
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
</x-layout>
