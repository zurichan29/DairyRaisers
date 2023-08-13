<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Product;
use App\Models\PaymentReciept;
use App\Models\User;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User_Address;
use App\Models\GuestUser;
use App\Models\GuestCart;
use App\Models\GuestOrder;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Events\OrderNotification;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('address')->where('id', $userId)->first();
            $address = $user->address;

            $defaultAddress = $user->address->where('default', true)->first();

            $cartItems = $user->cart;
            $cart = [];
            $grandTotal = $cartItems->sum('total');
            $shippingFee = 50;

            foreach ($cartItems as $cartItem) {
                $cart[] = [
                    'cartId' => $cartItem->id,
                    'product_id' => $cartItem->product->id,
                    'name' => $cartItem->product->name,
                    'img' => $cartItem->product->img,
                    'variant' => $cartItem->product->variant->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->total
                ];
            }
        } else {
            $defaultAddress = null;
            $address = session('guest_address');
            $cartItems = session('order_data', []);
            $grandTotal = 0;
            foreach ($cartItems as $item) {
                $grandTotal += $item['total'];
            }
        }

        if (empty($cartItems)) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'title' => 'Error',
                'body' => 'Please select atleast 1 product.',
                'period' => false,
            ]);
        }

        $paymentMethod = PaymentMethod::all();

        return view('client.checkout.show', [
            'defaultAddress' => $defaultAddress,
            'addresses' => $address,
            'items' => $cartItems,
            'grandTotal' => $grandTotal,
            'payment_methods' => $paymentMethod,
        ]);
    }

    public function uploadAndExtractText(Request $request)
    {
        try {
            // Get the uploaded file
            $file = $request->file('formFile');
            $validatedData = $request->validate([
                'formFile' => 'required|file|mimes:jpeg,png,jpg',
            ]);
            // Validate the file upload
            if (!$file) {
                return response()->json(['error' => 'Invalid file upload.'], 400);
            }

            // Move the file to a temporary location
            $path = $file->store('temp');

            // Perform OCR on the image using Tesseract OCR
            $text = (new TesseractOCR($path))->run();

            // Extract the desired information from the extracted text using regular expressions
            $pattern = '/Ref No\. (\d+)/';
            preg_match($pattern, $text, $matches);
            $refNo = $matches[1] ?? null;

            // Return the extracted reference number
            return response()->json(['refNo' => $refNo]);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            // Return a meaningful error message to the client
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showEditAddressForm(Request $request)
    {
        if (auth()->check()) {
            $address = User_Address::where('default', true)->where('user_id', auth()->user()->id)->first();
            if ($address) {
                $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
                $addressData = json_decode($jsonData, true);

                $allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR'];

                $regions = array_filter($addressData, function ($regionCode) use ($allowedRegionCodes) {
                    return in_array($regionCode, $allowedRegionCodes);
                }, ARRAY_FILTER_USE_KEY);

                $prev = $request->query('prev');

                return view('client.checkout.editAddressForm', compact('address', 'regions', 'addressData', 'prev'));
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkEditAddress(Request $request)
    {
        $id = $request->query('id');
        $prev = $request->query('prev');
        if (auth()->check()) {
            $address = User_Address::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
            if ($address) {
                $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
                $addressData = json_decode($jsonData, true);

                $addresses = $request->validate([
                    'region' => ['string', 'required', 'max:255'],
                    'province' => ['string', 'required', 'max:255'],
                    'barangay' => ['string', 'required', 'max:255'],
                    'municipality' => ['string', 'required', 'max:255'],
                    'street' => ['string', 'required', 'max:255'],
                    'label' => ['required', 'max:255', 'in:home,office'],
                    'zip_code' => ['integer', 'required', 'digits:4']
                ]);

                if (
                    isset($addressData[$addresses['region']]) &&
                    isset($addressData[$addresses['region']]['province_list'][$addresses['province']]) &&
                    isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]) &&
                    in_array($addresses['barangay'], $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]['barangay_list'])
                ) {
                    $regionName = $addressData[$addresses['region']]['region_name'];
                    // User input is valid
                } else {
                    // User input is invalid
                    throw ValidationException::withMessages([
                        'error' => 'Something went wrong with the address value, please try again.',
                    ]);
                }

                $address->region = $regionName;
                $address->province = $addresses['province'];
                $address->municipality = $addresses['municipality'];
                $address->barangay = $addresses['barangay'];
                $address->street = $addresses['street'];
                $address->label = $addresses['label'];
                $address->zip_code = $addresses['zip_code'];

                $address->save();

                if ($prev == 'checkout') {
                    return redirect()->route('checkout')->with('message', 'Address updated successfully');
                } else {
                    return redirect()->route('orders.re-order', ['id' => $prev])->with('message', 'Address updated successfully');
                }
            }
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function makeDefaultAddress(Request $request)
    {
        $user = Auth::user();
        $defaultAddressId = $request->input('default_address_id');

        User_Address::where('user_id', $user->id)->update(['default' => false]);

        $address = User_Address::where('user_id', $user->id)->findOrFail($defaultAddressId);
        $address->default = true;
        $address->save();

        return response()->json([
            'address' => $address,
        ]);
    }

    public function placeOrder(Request $request)
    {
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

        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('address')->where('id', $userId)->first();

            if (!$user->cart) {
                return redirect()->route('index')->with('message', [
                    'type' => 'error',
                    'title' => 'Error',
                    'body' => 'Please select atleast 1 product.',
                    'period' => false,
                ]);
            }

            $cart = $user->cart;
            $address = $user->address->where('default', true)->first();

            if ($address) {
                $completeAddress = $address->street . ' ' . $address->barangay . ', ' . $address->municipality . ', ' . $address->province . ', ' . $address->zip_code . ' Philippines';
            } else {
                $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
                $addressData = json_decode($jsonData, true);

                $addresses = $request->validate([
                    'region' => ['string', 'required', 'max:255'],
                    'province' => ['string', 'required', 'max:255'],
                    'barangay' => ['string', 'required', 'max:255'],
                    'municipality' => ['string', 'required', 'max:255'],
                    'street' => ['string', 'required', 'max:255'],
                    'label' => ['required', 'max:255', 'in:home,office'],
                    'zip_code' => ['integer', 'required', 'digits:4']
                ]);

                if (
                    isset($addressData[$addresses['region']]) &&
                    isset($addressData[$addresses['region']]['province_list'][$addresses['province']]) &&
                    isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]) &&
                    in_array($addresses['barangay'], $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]['barangay_list'])
                ) {
                    $regionName = $addressData[$request->input('region')]['region_name'];
                    // User input is valid
                } else {
                    // User input is invalid
                    throw ValidationException::withMessages([
                        'error' => 'Something went wrong on the address value, please try again.',
                    ]);
                }

                $user_address = new User_Address;
                $user_address->user_id = auth()->user()->id;
                $user_address->region = $regionName;
                $user_address->province = $request->input('province');
                $user_address->municipality = $request->input('municipality');
                $user_address->barangay = $request->input('barangay');
                $user_address->street = $request->input('street');
                $user_address->label = $request->input('label');
                $user_address->zip_code = $request->input('zip_code');
                $user_address->default = 1;
                $user_address->save();
                $completeAddress = $request->input('street') . ' ' . $request->input('barangay') . ', ' . $request->input('municipality') . ', ' . $request->input('province') . ', ' . $request->input('zip_code') . ' Philippines';
            }

            $cart_items = Cart::where('user_id', $userId)->get();
            $items = [];

            foreach ($cart_items as $item) {
                $product = Product::with('variant')->where('id', $item->product_id)->first();
                $items[] = [
                    "product_id" => $item->product_id,
                    "img" => $item->product->img,
                    "name" => $item->product->name,
                    'variant' => $product->variant->name,
                    "price" => $item->price,
                    "quantity" => $item->quantity,
                    "total" => $item->total,
                ];
            }
            Cart::where('user_id', $userId)->delete();

            $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $order = new Order;
            $order->name = $name;
            $order->mobile_number = auth()->user()->mobile_number;
            $order->order_number = $orderID;
            $order->address = $completeAddress;
            $order->remarks = $request->input('remarks');
            $order->grand_total = $cart->sum('total');
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
        } else {
            $request->validate([
                'name' => 'required|max:255|min:4',
                'mobile_number' => ['required', 'integer', 'digits:10', 'regex:/^9/'],
            ]);

            $orderData = session('order_data', []);

            if (empty($orderData)) {
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'title' => 'Error',
                    'body' => 'Please select atleast 1 product.',
                    'period' => false,
                ]);
            }
            $guestAddress = session('guest_address');
            $grandTotal = 0;
            foreach ($orderData as $item) {
                $grandTotal += $item['total'];
            }

            $order = new Order;
            $order->name = $request->name;
            $order->mobile_number = $request->mobile_number;
            $order->order_number = $orderID;
            $order->address = $guestAddress['complete_address'];
            $order->remarks = $request->input('remarks');
            $order->grand_total = $grandTotal;
            $order->payment_method = $paymentMethod->type;
            $order->reference_number = $referenceNumber;
            $order->shipping_option = 'Delivery';
            $order->customer_id = null;
            $order->customer_type = 'guest';
            $order->items = $orderData;
            $order->ip_address = $request->ip();

            if ($request->input('payment_method') != 'Cash On Delivery') {
                $order->payment_receipt = $filePath;
            }

            $order->save();

            session()->forget('guest_address');
            session()->forget('order_data');

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
