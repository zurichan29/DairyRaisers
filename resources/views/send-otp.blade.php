<!DOCTYPE html>
<html>

<head>
    <title>Send OTP</title>
</head>

<body>
    <h1>Send OTP</h1>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <form action="/send-otp" method="post">
        @csrf
        <input type="text" name="phone_number" placeholder="Phone Number" required>
        <button type="submit">Send OTP</button>
    </form>
</body>

</html>
