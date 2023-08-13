<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variants;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\User_Address;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
{
    //
    public function show(Request $request)
    {
        $variant = $request->input('variants', []);
        $searchQuery = $request->input('search_query');
        $products = Product::query();
        if ($products) {
            if (!empty($variant)) {
                $products->whereIn('variants_id', $variant);
            }

            if (!empty($searchQuery)) {
                $products->where('name', 'like', "%$searchQuery%");
            }

            // Sorting logic based on the selected option
            $sortBy = $request->input('sort_by');
            if ($sortBy === 'low_to_high') {
                $products->orderBy('price', 'asc');
            } elseif ($sortBy === 'high_to_low') {
                $products->orderBy('price', 'desc');
            }

            $products = $products->get();

            if ($request->ajax()) {
                return view('client.shop.filteredProducts', compact('products'));
            }


            $variants = Variants::all();
            $complete_address = null;

            if (auth()->check()) {
                $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();
                if ($address) {
                    $complete_address = $address->street . ' ' . $address->barangay . ', ' . $address->municipality . ', ' . $address->province . ', ' . $address->zip_code . ' Philippines';
                }
            }

            return view('client.shop.show', compact('products', 'variants', 'complete_address'));
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function updateCart(Request $request)
    {
        $productId = $request->product_id;
        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if (auth()->check()) {
            $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();

            if (empty($address)) {
                return response()->json(['errors' => 'setup location'], 422);
            }

            $item = Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->first();

            if ($item) {
                $item->quantity += 1;
                $item->total = $item->price * $item->quantity;
                $item->save();

                $quantity = $item->quantity;
            } else {
                $cart = new Cart;
                $cart->user_id = auth()->user()->id;
                $cart->product_id = $productId;
                $cart->quantity = 1;
                $cart->price = $product->price;
                $cart->total = $product->price;
                $cart->save();
                $quantity = 1;
            }
            $cartTotal = Cart::where('user_id', auth()->user()->id)->get()->sum('total');

            $carts = Cart::where('user_id', auth()->user()->id)->get();

            return response()->json(['product_name' => $product->name, 'count' => $carts->count(), 'total' => $cartTotal, 'quantity' => $quantity]);
        } else {

            $guestAddress = session('guest_address');
            $orderData = session('order_data', []);

            if (empty($guestAddress)) {
                return response()->json(['errors' => 'setup location'], 422);
            }

            $existingProductIndex = null;
            foreach ($orderData as $index => $item) {
                if ($item['product_id'] == $productId) {
                    $existingProductIndex = $index;
                    break;
                }
            }

            if ($existingProductIndex !== null) {
                $orderData[$existingProductIndex]['quantity'] += 1;
                $orderData[$existingProductIndex]['total'] = $orderData[$existingProductIndex]['price'] * $orderData[$existingProductIndex]['quantity'];

                session(['order_data' => $orderData]);

                $cartTotal = 0;
                foreach (session('order_data') as $item) {
                    $cartTotal += $item['total'];
                }

                $quantity = $orderData[$existingProductIndex]['quantity'];
            } else {
                $orderData[] = [
                    "product_id" => $product->id,
                    "img" => $product->img,
                    "name" => $product->name,
                    'variant' => $product->variant->name,
                    "price" => $product->price,
                    "quantity" => 1,
                    "total" => $product->price,
                ];
                session(['order_data' => $orderData]);
                $quantity = 1;
            }

            $cartTotal = 0;
            foreach (session('order_data') as $item) {
                $cartTotal += $item['total'];
            }
            return response()->json(['product_name' => $product->name, 'count' => count(session('order_data')), 'total' => $cartTotal, 'quantity' => $quantity]);
        }
    }

    public function fetchCart()
    {
        if (auth()->check()) {
            $orderData = Cart::where('user_id', auth()->user()->id)->get();
        } else {
            $orderData = session('order_data', []);
        }
        return response()->json(['orderData' => $orderData]);
    }

    public function location()
    {
        if (auth()->check()) {
            $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();
            if (empty($address)) {
                return view('client.shop.location');
            } else {
                return redirect()->route('index');
            }
        } else {
            $guestAddress = session('guest_address', []);

            if (empty($guestAddress)) {
                return view('client.shop.location');
            } else {
                return redirect()->route('index');
            }
        }
    }

    public function confirm_location(Request $request, $backRoute)
    {
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
        } else {
            throw ValidationException::withMessages([
                'address' => 'Something went wrong with the address value, please try again.',
            ]);
        }

        if (auth()->check()) {
            $address = User_Address::where('user_id', auth()->user()->id)->get();

            if ($address->count() != 2) {

                $user_address = new User_Address;
                $user_address->user_id = auth()->user()->id;
                $user_address->region = $regionName;
                $user_address->province = $request->input('province');
                $user_address->municipality = $request->input('municipality');
                $user_address->barangay = $request->input('barangay');
                $user_address->street = $request->input('street');
                $user_address->label = $request->input('label');
                $user_address->zip_code = $request->input('zip_code');
                ($address->count() == 0) ? $user_address->default = 1 : $user_address->default = 0;

                $user_address->save();

                if ($backRoute == 'address.create') {
                    return redirect()->route('profile.address')->with('message', [
                        'type' => 'info',
                        'title' => 'New Address',
                        'body' => 'Location confirmed successfully.',
                        'period' => false,
                    ]);
                } else {
                    return redirect()->route('shop')->with('message', [
                        'type' => 'info',
                        'title' => 'New Address',
                        'body' => 'Location confirmed successfully.',
                        'period' => false,
                    ]);
                }
            }

            throw ValidationException::withMessages([
                'error' => 'Maximum user address',
            ]);
        } else {
            $guestAddress = session('guest_address');
            if (empty($guestAddress)) {

                $guestAddress = [
                    'region' => $regionName,
                    'province' => $addresses['province'],
                    'municipality' => $addresses['municipality'],
                    'barangay' => $addresses['barangay'],
                    'street' => $addresses['street'],
                    'zip_code' => $addresses['zip_code'],
                    'label' => $addresses['label'],
                    'complete_address' => $request->input('street') . ' ' . $request->input('barangay') . ', ' . $request->input('municipality') . ', ' . $request->input('province') . ', ' . $request->input('zip_code') . ' Philippines',
                ];

                session(['guest_address' => $guestAddress]);

                return redirect()->route('shop')->with('message', [
                    'type' => 'info',
                    'title' => 'New Address',
                    'body' => 'Location confirmed successfully.',
                    'period' => false,
                ]);
            } else {
                return redirect()->route('index');
            }
        }
    }

    public function update_location_form()
    {
        if (auth()->check()) {
            $address = User_Address::where('user_id', auth()->user()->id)->where('default', 1)->first();
        } else {
            $address = session('guest_address');
        }

        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR'];

            $regions = array_filter($addressData, function ($regionCode) use ($allowedRegionCodes) {
                return in_array($regionCode, $allowedRegionCodes);
            }, ARRAY_FILTER_USE_KEY);

            return view('client.shop.update-location', compact('address', 'regions', 'addressData'));
        } else {
            return redirect()->route('index');
        }
    }

    public function update_location(Request $request)
    {
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
                $address['region'] = $regionName;
                $address['province'] = $addresses['province'];
                $address['municipality'] = $addresses['municipality'];
                $address['barangay'] = $addresses['barangay'];
                $address['street'] = $addresses['street'];
                $address['zip_code'] = $addresses['zip_code'];
                $address['label'] = $addresses['label'];
                $address->save();
            } else {

                $address['region'] = $regionName;
                $address['province'] = $addresses['province'];
                $address['municipality'] = $addresses['municipality'];
                $address['barangay'] = $addresses['barangay'];
                $address['street'] = $addresses['street'];
                $address['zip_code'] = $addresses['zip_code'];
                $address['label'] = $addresses['label'];
                $address['complete_address'] = $request->input('street') . ' ' . $request->input('barangay') . ', ' . $request->input('municipality') . ', ' . $request->input('province') . ', ' . $request->input('zip_code') . ' Philippines';

                session(['guest_address' => $address]);
            }
            return redirect()->route('shop')->with('message', 'asdasd');
        } else {
            return redirect()->route('index');
        }
    }
}
