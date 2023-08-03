<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\GuestCart;

class ShopController extends Controller
{
    //
    public function show(Request $request)
    {
        $variants = $request->input('variants', []);
        $products = Product::query();
        if ($products) {
            if (!empty($variants)) {
                $products->whereIn('variant', $variants);
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

            return view('client.shop.show', compact('products'));
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function addToCartForm($id)
    {
        $products = Product::all();
        $product = Product::find($id);
        // If product exists
        if ($product) {
            // Randomly select 5 unique products
            $products = $products->except($product->id);
            $randomProducts = $products->random(5)->unique();

            return view('client.shop.singleProductForm', ['product' => $product, 'randomProducts' => $randomProducts]);
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::where('id', $productId)->first();
        // If product exists
        if ($product) {
            $productId = (int)$productId;
            $quantity = (int)$request->input('quantity', 1);
            // For users account
            if (auth()->check()) {
                $userId = auth()->user()->id;
                $user = User::with('cart.product')->where('id', $userId)->first();
                $hasProductInCart = $user->cart->where('order_number', NULL)->contains('product_id', $productId);

                if ($hasProductInCart) {
                    $oldQuantity = $user->cart->where('product_id', $productId)->first();
                    $newQuantity = $quantity + $oldQuantity->quantity;
                    $newTotal = $newQuantity * $product->price;
                    Cart::where('user_id', $userId)->where('order_number', NULL)->where('product_id', $productId)->update([
                        'quantity' => $newQuantity,
                        'total' => $newTotal
                    ]);
                } else {
                    $cart = new Cart;
                    $total = $quantity * $product->price;
                    $cart->product_id = $productId;
                    $cart->user_id = $userId;
                    $cart->quantity = $quantity;
                    $cart->price = $product->price;
                    $cart->total = $total;
                    $cart->save();
                }
                // For guest users
            } else {
                $identifier = $request->cookie('device_identifier');
                $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
                $guest = GuestUser::with('guest_cart.product')->where('id', $thisGuest->id)->first();
                $guestCart = $guest->guest_cart->where('order_number', NULL)->contains('product_id', $productId);

                if ($guestCart) {
                    $oldQuantity = $guest->guest_cart->where('product_id', $productId)->first();
                    $newQuantity = $quantity + $oldQuantity->quantity;
                    $newTotal = $newQuantity * $product->price;
                    GuestCart::where('guest_user_id', $thisGuest->id)->where('order_number', NULL)->where('product_id', $productId)->update([
                        'quantity' => $newQuantity,
                        'total' => $newTotal
                    ]);
                } else {
                    $guest_cart = new GuestCart;
                    $total = $quantity * $product->price;
                    $guest_cart->product_id = $productId;
                    $guest_cart->guest_user_id = $thisGuest->id;
                    $guest_cart->quantity = $quantity;
                    $guest_cart->price = $product->price;
                    $guest_cart->total = $total;
                    $guest_cart->save();
                }
            }
            return redirect()->route('shop')->with('message', 'Product added to cart successfully.');
        }
        return redirect()->route('shop')->with('error', 'Something went wrong.');
    }
}
