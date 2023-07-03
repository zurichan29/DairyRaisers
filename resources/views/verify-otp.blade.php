<!DOCTYPE html>
<html>

<head>
    <title>Verify OTP</title>
</head>

<body>
    <h1>Verify OTP</h1>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <form action="/verify-otp" method="post">
        @csrf
        <input type="text" name="verification_id" value="{{ session('verification_id') }}" required readonly>
        <input type="text" name="otp" placeholder="OTP" required>
        <button type="submit">Verify OTP</button>
    </form>
</body>

</html>
