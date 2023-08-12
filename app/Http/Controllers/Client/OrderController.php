<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
        if (auth()->check()) {
            $orders = Order::with('customer')
                ->where('customer_type', 'online_shopper')
                ->where('customer_id', auth()->user()->id)
                ->orderByDesc('created_at')
                ->get();
            $firstData = $orders[0]->items[0];
        } else {
            $ip_address = $request->ip();
            $orders = Order::where('customer_type', 'guest')
                ->where('ip_address', $ip_address)
                ->orderByDesc('created_at')
                ->get();
            $firstData = $orders[0]->items[0];
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
            default:
                break;
        }

        return view('client.order.show', compact('order', 'user', 'cart', 'statusBadge'));
    }
    public function re_order($id)
    {

        $user = User::with('cart.product')->where('id', auth()->user()->id)->first();
        $order = Order::findOrFail($id);
        $items = $order->items;
        $grandTotal = 0;
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


        return view('client.order.re_order', compact('user', 'order', 'items', 'addresses', 'defaultAddress', 'payment_methods', 'grandTotal'));
    }
    public function place(Request $request, $id)
    {
        $order = Order::findOrFail($id);
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
                    $lastNumber = intval(substr($lastOrderId, -1)); // Extract last digit
                    $nextNumber = $lastNumber + 1;
                    return 'DR' . $monthYear . $nextNumber;
                }
            }
            // If no last order or the month/year has changed, reset the number to 1
            return 'DR' . $monthYear . '1';
        }

        $orderID = generateOrderId();

        $request->validate([
            'remarks' => ['max:255'],
            'payment_method' => ['required'],
        ]);

        if ($request->input('payment_method') != 'Cash On Delivery') {
            $paymentMethod = PaymentMethod::findOrFail($request->input('payment_method'))->where('status', 'ACTIVATED')->first();
            $request->validate([
                'reference_number' => ['required', 'max:255'],
            ]);
            $referenceNumber = $request->input('reference_number');
            if (!$paymentMethod) {
                throw ValidationException::withMessages([
                    'payment_method' => 'Something went wrong on the payment method, please try again.',
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
        $completeAddress = $address->street . ' ' . $address->barangay . ', ' . $address->municipality . ', ' . $address->province . ', ' . $address->zip_code . ' Philippines';
        // Create a new Order instance and save it
        $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $order = new Order;
        $order->name = $name;
        $order->mobile_number = auth()->user()->mobile_number;
        $order->order_number = $orderID;
        $order->address = $completeAddress;
        $order->remarks = $request->input('remarks');
        $order->grand_total = $grandTotal;
        $order->payment_method = $paymentMethod->type;
        $order->reference_number = $referenceNumber;
        $order->shipping_option = 'Delivery';
        $order->customer_id = $userId;
        $order->customer_type = 'online_shopper';
        $order->items = $items;
        $order->ip_address = $request->ip();

        if ($request->input('payment_method') != 'Cash On Delivery') {
            $order->payment_receipt = $filePath;
        }
        $order->save();
        event(new OrderNotification($order));


        return redirect()->route('order_history')->with('message', 'You have placed your order');
    }
}
