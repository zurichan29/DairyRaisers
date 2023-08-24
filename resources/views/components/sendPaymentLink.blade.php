@component('mail::message')
# Pay your Order : {{ $order['order_number'] }}

<p>Hello {{ $order['name'] }}!</p>
@component('mail::panel')
Please complete your payment for this order using the provided payment method.
@endcomponent
<p>Name: {{ $order['name'] }}</p>
<p>Mobile No. +63{{ $order['mobile_number'] }}</p>
<p>Email: {{ $order['email'] }}</p>
<p>Address: {{ $order['address'] }}</p>
<br>
<p>Order No. {{ $order['order_number'] }}</p>
<p>Reference No. {{ $order['reference_number'] }}</p>
<p>Payment Method: {{ $order['payment_method'] }}</p>
<p>Order Date: {{ $order['created_at'] }}</p>
<br>
@component('mail::table')
| Product             | Quantity                | Price                    | Total                    |
| ------------------- |:--------------------:   | :-----------------------:|-------------------------:|
@foreach ($order['items'] as $item)
| {{ $item['name'] }} | {{ $item['quantity'] }} | ₱{{ $item['price'] }}.00 | ₱{{ $item['total'] }}.00 |
@endforeach
@endcomponent
<h1 style="font-size: 18px">Grand Total: ₱{{ $order['grand_total'] }}.00</h1>
<br>
@component('mail::button', ['url' => route('checkout.show-payment', ['token' => $order->token, 'order_number' => $order['order_number'], 'email' => $order->email])])
Pay
@endcomponent
<p>Thank you for choosing us! If you have any questions or need further assistance, please feel free to contact our support team.</p>

<p>Thanks,<br>{{ config('app.name') }}</p>
@endcomponent
