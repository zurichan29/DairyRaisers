<x-layout>
    @include('client.components.header')
    {{-- <form action="">
        <label>Enter Phone Number</label>
        <input type="text" id="number">
        <br>
        <div id="recaptha-container"></div><br>
        <button type="button" onclick="sendCode()">Send Code</button>
    </form>
    <div id="error" style="color: red; display:none;"></div>
    <div id="sentMessage" style="color: green; display:none;"></div> --}}



    {{-- <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries
      
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
          apiKey: "AIzaSyB3nzcqfcg6hKAjtg6SWHxwIr4h_4AtPXo",
          authDomain: "dairy-raisers.firebaseapp.com",
          projectId: "dairy-raisers",
          storageBucket: "dairy-raisers.appspot.com",
          messagingSenderId: "1068745368281",
          appId: "1:1068745368281:web:072623db8ad4dc7f6e94c8",
          measurementId: "G-63Y6ME3WBH"
        };
      
        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);

        // Initialize Firebase
firebase.initializeApp(firebaseConfig);


// Initialize Firebase Cloud Messaging and get a reference to the service
const messaging = firebase.messaging();
      </script> --}}


    {{-- <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyB3nzcqfcg6hKAjtg6SWHxwIr4h_4AtPXo",
            authDomain: "dairy-raisers.firebaseapp.com",
            projectId: "dairy-raisers",
            storageBucket: "dairy-raisers.appspot.com",
            messagingSenderId: "1068745368281",
            appId: "1:1068745368281:web:072623db8ad4dc7f6e94c8",
            measurementId: "G-63Y6ME3WBH"
        }
    
        firebase.initializeApp(firebaseConfig);
    </script>
    
    <script type="text/javascript">
            window.onload = function(){
                    render();
            }
    
            function render() {
                    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptha-container');
                    recaptchaVerifier.render();
            }
    
            function sendCode() {
                var number = $('#number').val();
                
                firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult){
                    window.confirmationResult = confirmationResult;
                    coderesult = confirmationResult;

                    $('#sentMessage').text('Message Sent Successfully!');
                    $('#sentMessage').show();
                }).catch(function(error) {
                    $('#error').text(error.message);
                    $('#error').show();
                });
            }
    </script> --}}
    @include('client.components.footer')
</x-layout>
