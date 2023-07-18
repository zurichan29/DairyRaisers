<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User_Address;
use App\Models\GuestUser;
use App\Models\GuestCart;
use App\Models\GuestOrder;
use App\Models\PaymentMethod;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('order')->with('address')->where('id', $userId)->first();
            $address = $user->address;
            $defaultAddress = $user->address->where('default', true)->first();
            $cartItems = $user->cart->where('order_number', null);
            $cart = [];
            $grandTotal = $cartItems->sum('total');
            $shippingFee = 50;

            foreach ($cartItems as $cartItem) {
                $cart[] = [
                    'cartId' => $cartItem->id,
                    'productId' => $cartItem->product->id,
                    'name' => $cartItem->product->name,
                    'img' => $cartItem->product->img,
                    'variant' => $cartItem->product->variant,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->total
                ];
            }
            $grandTotal += $shippingFee;
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->where('id', $thisGuest->id)->first();

            $address = null;
            $cart = $guest->guest_cart->where('order_number', NULL);
            $grandTotal = $cart->sum('total');
        }

        $paymentMethod = PaymentMethod::all();

        return view('client.checkout.show', [
            'defaultAddress' => $defaultAddress,
            'addresses' => $address,
            'items' => $cart,
            'grandTotal' => $grandTotal,
            'payment_methods' => $paymentMethod
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
                return view('client.checkout.editAddressForm', ['address' => $address]);
            }
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkEditAddress(Request $request)
    {
        $id = $request->query('id');
        if (auth()->check()) {
            $address = User_Address::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
            if ($address) {
                $request->validate([
                    'street' => ['string', 'required', 'max:255'],
                    'barangay' => ['string', 'required', 'max:255'],
                    'city' => ['string', 'required', 'max:255'],
                    'province' => ['string', 'required', 'max:255'],
                    'zip_code' => ['numeric', 'digits:4', 'required'],
                    'remarks' => ['string', 'required', 'max:255'],
                    'label' => ['string', 'required'],
                ]);

                $address->update([
                    'street' => $request->input('street'),
                    'barangay' => $request->input('barangay'),
                    'city' => $request->input('city'),
                    'province' => $request->input('province'),
                    'zip_code' => $request->input('zip_code'),
                    'remarks' => $request->input('remarks'),
                    'label' => $request->input('label'),
                ]);

                return redirect()->route('checkout')->with('message', 'Address updated successfully');
            }
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function makeDefaultAddress(Request $request)
    {
        $user = Auth::user();
        $defaultAddressId = $request->input('default_address_id');

        // Update the default flag for user addresses
        User_Address::where('user_id', $user->id)->update(['default' => false]);

        // Set the selected address as the default
        $address = User_Address::where('user_id', $user->id)->findOrFail($defaultAddressId);
        $address->default = true;
        $address->save();

        return response()->json([
            'address' => $address,
        ]);
    }

    public function placeOrder(Request $request)
    {
        dd($request);
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
            'remarks' => ['string', 'max:255'],
        ]);

        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->with('order')->with('address')->where('id', $userId)->first();

            if (!$user->cart) {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }

            if (!$user->address->where('default', 1)->first()) {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }

            $cart = $user->cart->first();
            $address = $user->address->where('default', true)->first();

            if ($address) {
                $completeAddress = $address->street . ' ' . $address->barangay . ', ' . $address->city . ', ' . $address->province . ', ' . $address->zip_code . ' Philippines';
            } else {
                $request->validate([
                    'province' => ['string', 'required', 'max:255'],
                    'barangay' => ['string', 'required', 'max:255'],
                    'city' => ['string', 'required', 'max:255'],
                    'street' => ['string', 'required', 'max:255'],
                    'label' => ['required', 'max:255', 'in:home,label'],
                    'zip_code' => ['integer', 'required', 'digits:4']
                ]);

                $user_address = new User_Address;
                $user_address->user_id = auth()->user()->id;
                $user_address->province = $request->input('province');
                $user_address->city = $request->input('city');
                $user_address->barangay = $request->input('barangay');
                $user_address->street = $request->input('street');
                $user_address->label = $request->input('label');
                $user_address->zip_code = $request->input('zip_code');
                $user_address->default = 1;
                $user_address->save();
                $completeAddress = $request->input('street') . ' ' . $request->input('barangay') . ', ' . $request->input('city') . ', ' . $request->input('province') . ', ' . $request->input('zip_code') . ' Philippines';
            }

            Cart::where('user_id', $userId)->where('order_number', NULL)->update(['order_number' => $orderID]);
            $order = new Order;
            $order->user_id = $userId;
            $order->order_number = $orderID;
            $order->user_address = $completeAddress;
            $order->remarks = $request->input('remarks');
            $order->grand_total = $cart->where('order_number', $orderID)->sum('total');
            $order->payment_method = 'COD';
            $order->save();
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->where('id', $thisGuest->id)->first();
            $cart = $guest->guest_cart->first();

            $request->validate([
                'first_name' => ['string', 'required', 'max:255'],
                'last_name' => ['string', 'required', 'max:255'],
                'mobile_number' => ['required', 'numeric', 'digits:10', 'regex:/^9[0-9]{9}$/'],
                'province' => ['string', 'required', 'max:255'],
                'barangay' => ['string', 'required', 'max:255'],
                'city' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'label' => ['required', 'max:255', 'in:home,office'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ], [
                'mobile_number.regex' => 'The :attribute must be a valid phone number with 10 characters and starting with 9.',
            ]);

            $completeAddress = $request->input('street') . ' ' . $request->input('barangay') . ', ' . $request->input('city') . ', ' . $request->input('province') . ', ' . $request->input('zip_code') . ' Philippines';

            GuestCart::where('guest_user_id', $guest->id)->where('order_number', NULL)->update(['order_number' => $orderID]);
            $order = new GuestOrder;
            $order->guest_user_id = $guest->id;
            $order->first_name = $request->input('first_name');
            $order->last_name = $request->input('last_name');
            $order->mobile_number = $request->input('mobile_number');
            $order->order_number = $orderID;
            $order->guest_address = $completeAddress;
            $order->remarks = $request->input('remarks');
            $order->grand_total = $cart->where('order_number', $orderID)->sum('total');
            $order->payment_method = 'COD';
            $order->save();
        }
        return redirect()->route('order_history')->with('message', 'You have placed your order');
    }
}
