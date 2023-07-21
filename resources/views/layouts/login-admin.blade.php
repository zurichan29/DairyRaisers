<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Login at Dairy Raisers</title>
</head>
<body>
    @yield('content')
</body>
</html>