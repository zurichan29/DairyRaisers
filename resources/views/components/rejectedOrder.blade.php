@component('mail::message')
# Order Rejected : {{ $order['order_number'] }}

<p>Hello {{ $order['name'] }}!</p>
@component('mail::panel')
We regret to inform you that your order with the following details has been rejected:
@endcomponent
@component('mail::panel')
Reason: {{ $order['comments'] }}
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
<p>If you have any questions or concerns regarding the rejection, please feel free to reach out to our support team.</p>
<p>We apologize for any inconvenience caused and thank you for considering us.</p>

<p>Thanks,<br>{{ config('app.name') }}</p>
@endcomponent
