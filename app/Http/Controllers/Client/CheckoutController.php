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
use Illuminate\Support\Facades\Http;
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
        $delivery_fee = 38;
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('address')->where('id', $userId)->first();
            $address = $user->address;

            $defaultAddress = $user->address->where('default', true)->first();
            $cartItems = $user->cart;
            $cart = [];
            $grandTotal = $cartItems->sum('total');

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

        if (!$cartItems->isNotEmpty()) {
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
            'delivery_fee' => $delivery_fee
        ]);
    }

    public function update_location_checkout(Request $request)
    {
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

        if (auth()->check()) {
            $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();
        } else {
            $address = session('guest_address');
        }

        if ($address) {
            if (auth()->check()) {
                $address['region'] = $addresses['region'];
                $address['province'] = $addresses['province'];
                $address['municipality'] = $addresses['municipality'];
                $address['barangay'] = $addresses['barangay'];
                $address['street'] = $addresses['street'];
                $address['zip_code'] = $addresses['zip_code'];
                $address->save();
            } else {

                $address['region'] = $addresses['region'];
                $address['province'] = $addresses['province'];
                $address['municipality'] = $addresses['municipality'];
                $address['barangay'] = $addresses['barangay'];
                $address['street'] = $addresses['street'];
                $address['zip_code'] = $addresses['zip_code'];
                $address['complete_address'] = $request->input('street') . ' ' . $request->input('barangay') . ', ' . $request->input('municipality') . ', ' . $request->input('province') . ', ' . $request->input('zip_code') . ' Philippines';

                session(['guest_address' => $address]);
            }
            return redirect()->route('shop')->with('message', [
                'type' => 'info',
                'title' => 'Address updated',
                'body' => null,
                'period' => false,
            ]);
        } else {
            return redirect()->route('index');
        }
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
        $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();

        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            return view('client.checkout.editAddressForm', compact('address', 'addressData'));
        } else {
            return redirect()->route('index');
        }
    }

    public function checkEditAddress(Request $request)
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

            return redirect()->route('checkout')->with('message', [
                'type' => 'info',
                'title' => 'Address updated',
                'body' => 'Address has been updated.',
                'period' => false,
            ]);
        } else {
            return redirect()->route('index');
        }
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
                    $lastNumber = intval(substr($lastOrderId, 0, -6)); // Extract first digit
                    $nextNumber = $lastNumber + 1;
                    return $nextNumber . 'DR' . $monthYear;
                }
            }

            // If no last order or the month/year has changed, reset the number to 1
            return '1DR' . $monthYear;
        }

        $orderID = generateOrderId();
        $request->validate([
            'remarks' => ['max:255'],
            'payment_method' => ['required'],
        ]);

        if ($request->input('payment_method') != 'Cash On Delivery') {
            $Method = PaymentMethod::findOrFail($request->input('payment_method'))->where('status', 'ACTIVATED')->first();
            $request->validate([
                'reference_number' => ['required', 'max:255'],
            ]);
            $referenceNumber = $request->input('reference_number');
            if (!$Method) {
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

            $paymentMethod = $Method->type;
        } else {
            $paymentMethod = 'Cash On Delivery';
            $referenceNumber = NULL;
            $filePath = NULL;
        }

        // Check if the Pusher API is reachable
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

        $delivery_fee = 38;

        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('address')->where('id', $userId)->first();

            if (!$user->cart) {
                return redirect()->route('index')->with('message', [
                    'type' => 'error',
                    'title' => ' Empty Cart',
                    'body' => 'Your cart is empty. Please add items before proceeding to checkout.',
                    'period' => false,
                ]);
            }

            $cart = $user->cart;
            $address = $user->address->where('default', true)->first();

            if ($address) {
                $completeAddress = $address->street . ' ' . ucwords(strtolower($address->barangay)) . ', ' . ucwords(strtolower($address->municipality)) . ', ' . ucwords(strtolower($address->province)) . ', ' . $address->zip_code . ' Philippines';
            } else {
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

                $user_address = new User_Address;
                $user_address->user_id = auth()->user()->id;
                $user_address->region = $addresses['region'];
                $user_address->province = $addresses['province'];
                $user_address->municipality = $request->input('municipality');
                $user_address->barangay = $request->input('barangay');
                $user_address->street = $request->input('street');
                $user_address->zip_code = $request->input('zip_code');
                $user_address->default = 1;
                $user_address->save();
                $completeAddress = $request->input('street') . ' ' . ucwords(strtolower($request->input('barangay'))) . ', ' . ucwords(strtolower($request->input('municipality'))) . ', ' . ucwords(strtolower($request->input('province'))) . ', ' . $request->input('zip_code') . ' Philippines';
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

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);

                if ($product) {
                    if ($product->status == 'AVAILABLE') {
                    } else {
                        return redirect()->back()->with('message', [
                            'type' => 'error',
                            'title' => 'Product Status Alert',
                            'body' => 'The status of some selected products is set to "Not Available". Please review and update the product availability if necessary.',
                            'period' => false,
                        ]);
                    }
                    $remainingStock = $product->stocks - $item['quantity'];

                    if ($remainingStock >= 0) {
                    } else {
                        return redirect()->back()->with('message', [
                            'type' => 'error',
                            'title' => 'Insufficient Stock',
                            'body' => "The quantity you're trying to order exceeds the available stock. Please adjust your order quantity.",
                            'period' => false,
                        ]);
                    }
                } else {
                    return redirect()->back()->with('message', [
                        'type' => 'error',
                        'title' => 'Product Not Found',
                        'body' => "The requested product was not found in our database. Please verify the product details and try again.",
                        'period' => false,
                    ]);
                }
            }
            Cart::where('user_id', $userId)->delete();

            $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $order = new Order;
            $order->name = $name;
            $order->mobile_number = auth()->user()->mobile_number;
            $order->email  = auth()->user()->email;
            $order->order_number = $orderID;
            $order->address = $completeAddress;
            $order->remarks = $request->input('remarks');
            $order->grand_total = $cart->sum('total') + $delivery_fee;;
            $order->payment_method = $paymentMethod;
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

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                $remainingStock = $product->stocks - $item['quantity'];
                $product->stocks = $remainingStock;
                $product->save();
            }

            if (isPusherReachable()) {
                event(new OrderNotification($order));
            }
        } else {
            $request->validate([
                'name' => 'required|max:255|min:4',
                'mobile_number' => ['required', 'integer', 'digits:10', 'regex:/^9/'],
                'email' => ['required', 'email'],
            ]);

            $orderData = session('order_data', []);

            if (empty($orderData)) {
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'title' => ' Empty Cart',
                    'body' => 'Your cart is empty. Please add items before proceeding to checkout.',
                    'period' => false,
                ]);
            }

            foreach ($orderData as $item) {
                $product = Product::find($item['product_id']);

                if ($product) {
                    if ($product->status == 'AVAILABLE') {
                    } else {
                        return redirect()->back()->with('message', [
                            'type' => 'error',
                            'title' => 'Product Status Alert',
                            'body' => 'The status of some selected products is set to "Not Available". Please review and update the product availability if necessary.',
                            'period' => false,
                        ]);
                    }
                    $remainingStock = $product->stocks - $item['quantity'];

                    if ($remainingStock >= 0) {
                    } else {
                        return redirect()->back()->with('message', [
                            'type' => 'error',
                            'title' => ' Insufficient Stock',
                            'body' => "The quantity you're trying to order exceeds the available stock. Please adjust your order quantity.",
                            'period' => false,
                        ]);
                    }
                } else {
                    return redirect()->back()->with('message', [
                        'type' => 'error',
                        'title' => 'Product Not Found',
                        'body' => "The requested product was not found in our database. Please verify the product details and try again.",
                        'period' => false,
                    ]);
                }
            }

            foreach ($orderData as $item) {
                $product = Product::find($item['product_id']);
                $remainingStock = $product->stocks - $item['quantity'];
                $product->stocks = $remainingStock;
                $product->save();
            }


            $guestAddress = session('guest_address');
            $grandTotal = 0;
            foreach ($orderData as $item) {
                $grandTotal += $item['total'];
            }

            $order = new Order;
            $order->name = $request->name;
            $order->mobile_number = $request->mobile_number;
            $order->email  = $request->email;
            $order->order_number = $orderID;
            $order->address = $guestAddress['complete_address'];
            $order->remarks = $request->input('remarks');
            $order->grand_total = $grandTotal + $delivery_fee;
            $order->payment_method = $paymentMethod;
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

            session()->forget('order_data');

            if (isPusherReachable()) {
                event(new OrderNotification($order));
            }
        }
        return redirect()->route('order_history')->with('message', [
            'type' => 'success',
            'title' => 'Order Placed',
            'body' => 'Your order has been successfully placed. Thank you for shopping with us!',
            'period' => false,
        ]);
    }
}
