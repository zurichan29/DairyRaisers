{{-- resources/views/view.name.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Rejected Order</title>
</head>
<body>
    <h1>Hello {{ $orderData['first_name'] }},</h1>
    <p>Your order has been rejected. Here are the details:</p>
    <p>Order No. {{ $orderData['order_number'] }}</p>
    <p>Reference No. {{ $orderData['reference_number'] }}</p>
    <p>Order Date: {{ $orderData['created_at'] }}</p>
    <p>Rejected Reason: {{ $orderData['comments'] }}</p>
    <!-- You can display other order details here as needed -->
</body>
</html>
