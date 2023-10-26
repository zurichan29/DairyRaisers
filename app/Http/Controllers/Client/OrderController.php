<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Events\OrderNotification;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\GuestCart;
use App\Models\GuestOrder;
use App\Models\User_Address;
use App\Models\DeliveryFee;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $firstData = null;
        if (auth()->check()) {
            $orders = Order::with('customer')
                ->where('customer_type', 'online_shopper')
                ->where('customer_id', auth()->user()->id)
                ->orderByDesc('created_at')
                ->get();
            if (!$orders->isEmpty()) {
                $firstData = $orders[0]->items[0];
            }
        } else {
            $ip_address = $request->ip();

            $orders = Order::where('customer_type', 'guest')
                ->where('ip_address', $ip_address)
                ->orderByDesc('created_at')
                ->get();
            if (!$orders->isEmpty()) {
                $firstData = $orders[0]->items[0];
            }
        }
        return view('client.order.index', compact('orders', 'firstData'));
    }
    public function show($id)
    {
        if (auth()->check()) {
            $order = Order::findOrFail($id);
            $user = User::with('cart.product')->with('address')->where('id', auth()->user()->id)->first();
            $cart = $order->items;
        } else {
            $order = Order::findOrFail($id);
            $cart = $order->items;
            $user = null;
        }

        $statusBadge = null;
        switch ($order->status) {
            case 'Pending':
                $statusBadge = 'badge-info';
                break;
            case 'Approved':
                $statusBadge = 'badge-primary';
                break;
            case 'On The Way':
                $statusBadge = 'badge-warning';
                break;
            case 'Delivered':
                $statusBadge = 'badge-success';
                break;
            case 'Rejected':
                $statusBadge = 'badge-danger';
                break;
            default:
                break;
        }

        return view('client.order.show', compact('order', 'user', 'cart', 'statusBadge'));
    }
    public function re_order($id)
    {

        $user = User::with('cart.product')->with('address')->where('id', auth()->user()->id)->first();
        $order = Order::findOrFail($id);
        $items = $order->items;
        $grandTotal = 0;
        $address = $user->address->where('default', true)->first();
        $DeliveryFee = DeliveryFee::where('municipality', $address->municipality)->first();
        $delivery_fee = $DeliveryFee->fee;
        foreach ($items as $item) {
            $grandTotal += $item['total'];
        }
        $addresses = $user->address;
        $defaultAddress = $user->address->where('default', true)->first();
        $payment_methods = PaymentMethod::all();
        
        if ($order) {
        } else {
            return redirect()->route('index');
        }


        return view('client.order.re_order', compact('user', 'order', 'items', 'addresses', 'defaultAddress', 'payment_methods', 'grandTotal', 'delivery_fee'));
    }

    public function showEditAddressForm(Request $request, $id)
    {
        $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();
        $order_id = $id;
        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            return view('client.order.editAddressForm', compact('order_id', 'address', 'addressData'));
        } else {
            return redirect()->route('index');
        }
    }

    public function checkEditAddress(Request $request, $id)
    {
        $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();

        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $addresses = $request->validate([
                'barangay' => ['string', 'required', 'max:255'],
                'municipality' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ]);

            // Set the fixed region and province
            $addresses['region'] = '4A';
            $addresses['province'] = 'CAVITE';

            // Validation for municipality and barangay
            $municipality = $request->input('municipality');
            $barangay = $request->input('barangay');

            // Validate if the municipality and barangay are valid within the fixed region and province
            if (
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$municipality]) &&
                in_array($barangay, $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$municipality]['barangay_list'])
            ) {
                // Address validation successful, continue storing process

                // Rest of the code remains unchanged
            } else {
                throw ValidationException::withMessages([
                    'address' => 'Something went wrong with the address value, please try again.',
                ]);
            }
            $address['region'] = $addresses['region'];
            $address['province'] = $addresses['province'];
            $address['municipality'] = $addresses['municipality'];
            $address['barangay'] = $addresses['barangay'];
            $address['street'] = $addresses['street'];
            $address['zip_code'] = $addresses['zip_code'];
            $address->save();

            return redirect()->route('orders.re-order', ['id' => $id])->with('message', [
                'type' => 'info',
                'title' => 'Address updated',
                'body' => 'Address has been updated.',
                'period' => false,
            ]);
        } else {
            return redirect()->route('index');
        }
    }
    public function place(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $delivery_fee = 0;
    
        function generateOrderId()
        {
            $currentDate = now();
            $monthYear = $currentDate->format('my');
            $lastOrder = DB::table('orders')->orderByDesc('id')->first();

            if ($lastOrder) {
                $lastOrderDate = Carbon::parse($lastOrder->created_at);
                $lastOrderMonthYear = $lastOrderDate->format('my');

                if ($lastOrderMonthYear === $monthYear) {
                    $lastOrderId = $lastOrder->order_number;
                    $lastNumber = intval(substr($lastOrderId, 0, -6)); // Extract first digit
                    $nextNumber = $lastNumber + 1;
                    return $nextNumber . 'DR' . $monthYear;
                }
            }

            // If no last order or the month/year has changed, reset the number to 1
            return '1DR' . $monthYear;
        }

        function isPusherReachable()
        {
            try {
                // Send a GET request to the Pusher API endpoint
                $response = Http::get('https://api-ap1.pusher.com');
                return $response->successful();
            } catch (\Exception $e) {
                return false;
            }
        }

        $orderID = generateOrderId();

        $request->validate([
            'remarks' => ['max:255'],
            'payment_method' => ['required'],
        ]);

        if ($request->input('payment_method') != 'Cash On Delivery') {
            $Method = PaymentMethod::findOrFail('id', $request->input('payment_method'))->where('status', 'ACTIVATED')->first();
            $request->validate([
                'reference_number' => ['required', 'max:255'],
            ]);
            $referenceNumber = $request->input('reference_number');
            if (!$Method) {
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'title' => 'Payment Method Error',
                    'body' => 'Something went wrong on the payment method, please try again.',
                    'period' => false,
                ]);
            }
            $validator = Validator::make($request->all(), [
                'formFile' => 'required|image|mimes:png,jpg,jpeg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $file = $request->file('formFile');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/images/payment_reciept', $fileName);
            $filePath = 'images/payment_reciept/' . $fileName;

            $paymentMethod = $Method->type;
        } else {
            $paymentMethod = 'Cash On Delivery';
            $referenceNumber = NULL;
            $filePath = NULL;
        }


        $userId = auth()->user()->id;
        $user = User::with('cart.product')->with('address')->where('id', $userId)->first();

        if (!$user->cart) {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }

        $items = $order->items;
        $grandTotal = 0;
        foreach ($items as $item) {
            $grandTotal += $item['total'];
        }

        $address = $user->address->where('default', true)->first();
        $completeAddress = $address->street . ' ' . ucwords(strtolower($address->barangay)) . ', ' . ucwords(strtolower($address->municipality)) . ', ' . ucwords(strtolower($address->province)) . ', ' . $address->zip_code . ' Philippines';
        // Create a new Order instance and save it
        $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
       $DeliveryFee = DeliveryFee::where('municipality', $address->municipality)->first();
       $delivery_fee = $DeliveryFee->fee;

        $order = new Order;
        $order->name = $name;
        $order->mobile_number = auth()->user()->mobile_number;
        $order->email = auth()->user()->email;
        $order->order_number = $orderID;
        $order->address = $completeAddress;
        $order->remarks = $request->input('remarks');
        $order->grand_total = $grandTotal + $delivery_fee;
        $order->payment_method = $paymentMethod;
        $order->reference_number = $referenceNumber;
        $order->shipping_option = 'Delivery';
        $order->delivery_fee = $delivery_fee;
        $order->customer_id = $userId;
        $order->customer_type = 'online_shopper';
        $order->items = $items;
        $order->ip_address = $request->ip();

        if ($request->input('payment_method') != 'Cash On Delivery') {
            $order->payment_receipt = $filePath;
        }
        $order->save();
        if (isPusherReachable()) {
            event(new OrderNotification($order));
        }

        return redirect()->route('order_history')->with('message', [
            'type' => 'success',
            'title' => 'Order Placed',
            'body' => 'Your order has been successfully placed. Thank you for shopping with us!',
            'period' => false,
        ]);
    }
}
