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
            $user = User::with('cart.product')->with('order')->where('id', auth()->user()->id)->first();
            $orders = $user->order->sortByDesc('created_at');
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->with('guest_order')->where('id', $thisGuest->id)->first();
            $orders = $guest->guest_order->where('delivery_status', '<>', 'delivered');

            if ($orders) {
                foreach ($orders as $order) {
                    $cartItems = $guest->guest_cart->where('order_number', $order->order_number);
                    $user_order[$order->id] = [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'full_name' => $order->first_name . ' ' . $order->last_name,
                        'mobile_number' => $order->mobile_number,
                        'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y-m-d g:i A'),
                        'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('Y-m-d g:i A'),
                        'address' => $order->guest_address,
                        'remarks' => $order->remarks,
                        'delivery_status' => $order->delivery_status,
                        'payment_method' => $order->payment_method,
                        'grand_total' => $order->grand_total + 50,
                    ];

                    foreach ($cartItems as $cartItem) {
                        $total = $cartItem->quantity * $cartItem->product->price;
                        $user_order[$order->id]['cart_item'][] = [
                            'cartId' =>  $cartItem->id,
                            'productId' => $cartItem->product->id,
                            'name' => $cartItem->product->name,
                            'img' => $cartItem->product->img,
                            'variant' => $cartItem->product->variant,
                            'price' => $cartItem->product->price,
                            'quantity' => $cartItem->quantity,
                            'total' => $total
                        ];
                    }
                }
            }
        }

        return view('client.order.index', ['orders' => $orders, 'user' => $user]);
    }

    public function show($id)
    {
        if (auth()->check()) {
            $order = Order::findOrFail($id);
            $user = User::with('cart.product')->with('order')->with('address')->where('id', $order->user->id)->first();
            $cart = $user->cart->where('order_number', $order->order_number);
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
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->with('guest_order')->where('id', $thisGuest->id)->first();
            $orders = $guest->guest_order->where('delivery_status', '<>', 'delivered');

            if ($orders) {
                foreach ($orders as $order) {
                    $cartItems = $guest->guest_cart->where('order_number', $order->order_number);
                    $user_order[$order->id] = [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'full_name' => $order->first_name . ' ' . $order->last_name,
                        'mobile_number' => $order->mobile_number,
                        'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y-m-d g:i A'),
                        'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('Y-m-d g:i A'),
                        'address' => $order->guest_address,
                        'remarks' => $order->remarks,
                        'delivery_status' => $order->delivery_status,
                        'payment_method' => $order->payment_method,
                        'grand_total' => $order->grand_total + 50,
                    ];

                    foreach ($cartItems as $cartItem) {
                        $total = $cartItem->quantity * $cartItem->product->price;
                        $user_order[$order->id]['cart_item'][] = [
                            'cartId' =>  $cartItem->id,
                            'productId' => $cartItem->product->id,
                            'name' => $cartItem->product->name,
                            'img' => $cartItem->product->img,
                            'variant' => $cartItem->product->variant,
                            'price' => $cartItem->product->price,
                            'quantity' => $cartItem->quantity,
                            'total' => $total
                        ];
                    }
                }
            }
        }

        return view('client.order.show', compact('order', 'user', 'cart', 'statusBadge'));
    }

    public function re_order($id)
    {
        if (auth()->check()) {
            $user = User::with('cart.product')->with('order')->where('id', auth()->user()->id)->first();
            $order = $user->order->where('id', $id)->first();
            $items = $user->cart->where('order_number', $order->order_number);
            $grandTotal = $items->sum('total');
            $addresses = $user->address;
            $defaultAddress = $user->address->where('default', true)->first();
            $payment_methods = PaymentMethod::all();
            if ($order) {
            } else {
                return redirect('/');
            }
        }

        return view('client.order.re_order', compact('user', 'order', 'items', 'addresses', 'defaultAddress', 'payment_methods', 'grandTotal'));
    }

    public function place(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        function generateOrderId()
        {
            $currentDate = Carbon::now();
            $monthYear = $currentDate->format('my');
            $lastOrder = DB::table('order')->orderByDesc('id')->first();

            if ($lastOrder) {
                $lastOrderDate = Carbon::parse($lastOrder->created_at);
                $lastOrderMonthYear = $lastOrderDate->format('my');

                if ($lastOrderMonthYear === $monthYear) {
                    $lastOrderId = $lastOrder->order_number;
                    $lastNumber = explode('-', $lastOrderId)[2];
                    $nextNumber = intval($lastNumber) + 1;
                    return 'DR-' . $monthYear . '-' . $nextNumber;
                }
            }
            // If no last order or the month/year has changed, reset the number to 1
            return 'DR-' . $monthYear . '-1';
        }

        $orderID = generateOrderId();

        $request->validate([
            'remarks' => ['max:255'],
            'payment_method' => ['required'],
            'delivery_option' => ['required', 'in:Delivery,Pick Up'],
        ]);

        $deliveryOption = $request->input('delivery_option');
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

        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('order')->with('address')->where('id', $userId)->first();

            if (!$user->cart) {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }

            $selectedCart = Cart::where('user_id', $userId)
                ->where('order_number', $order->order_number)
                ->get();

            foreach ($selectedCart as $item) {
                Cart::create([
                    'product_id' => $item->product_id,
                    'user_id' => $item->user_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price, // Copy the 'price' from the original record
                    'total' => $item->total,
                    'order_number' => $orderID,
                ]);
            }


            $address = $user->address->where('default', true)->first();
            $completeAddress = $address->street . ' ' . $address->barangay . ', ' . $address->municipality . ', ' . $address->province . ', ' . $address->zip_code . ' Philippines';
            // Create a new Order instance and save it
            $order = new Order;
            $order->user_id = $userId;
            $order->order_number = $orderID;
            $order->user_address = $completeAddress;
            $order->remarks = $request->input('remarks');
            $order->grand_total = Cart::where('order_number', $orderID)->sum('total');
            $order->payment_method = $paymentMethod->type;
            $order->reference_number = $referenceNumber;
            $order->delivery_option = $deliveryOption;

            if ($request->input('payment_method') != 'Cash On Delivery') {
                $order->payment_reciept = $filePath;
            }
            $order->save();
            event(new OrderNotification($order));
        }

        return redirect()->route('order_history')->with('message', 'You have placed your order');
    }
}
