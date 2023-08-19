<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <link href="{{ asset('css/order-print.css') }}" rel="stylesheet" media="print">
</head>
<body>
    <h1>{{ $order->order_number }}</h1>
    <!-- Your invoice content goes here -->
    <!-- Use the data from the $order variable to populate the content -->
</body>
</html>
