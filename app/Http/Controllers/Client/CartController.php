<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\GuestCart;

class CartController extends Controller
{
    //

    public function cart(Request $request)
    {
        $userCart = [];
        $grand_total = 0;
        // For users account
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::with('cart.product')->where('id', $userId)->first();
            if ($user) {
                $cartItems = $user->cart->where('order_number', null);

                foreach ($cartItems as $cartItem) {
                    $total = $cartItem->quantity * $cartItem->product->price;
                    $userCart[] = [
                        'cartId' =>  $cartItem->id,
                        'productId' => $cartItem->product->id,
                        'name' => $cartItem->product->name,
                        'img' => $cartItem->product->img,
                        'variant' => $cartItem->product->variant,
                        'price' => $cartItem->product->price,
                        'quantity' => $cartItem->quantity,
                        'total' => $total
                    ];
                    $grand_total += $total;
                }
            }
            // For guest users
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->where('id', $thisGuest->id)->first();

            foreach ($guest->guest_cart as $cart) {
                $total = $cart->quantity * $cart->product->price;
                $userCart[] = [
                    'cartId' => $cart['id'],
                    'productId' => $cart['product_id'],
                    'name' => $cart->product->name,
                    'img' => $cart->product->img,
                    'variant' => $cart['variant'],
                    'price' => $cart['price'],
                    'quantity' => $cart['quantity'],
                    'total' => $total
                ];
                $grand_total += $total;
            }
        }

        return view('client.page.shop.cart', ['cart' => $userCart, 'grand_total' => $grand_total]);
    }

    public function updateQuantity(Request $request, $id)
    {
        $grandTotal = 0;
        // For users account
        if (auth()->check()) {
            $cart = Cart::findOrFail($id);
            $cart->quantity = (int)$request->quantity;
            $cart->total = $cart->product->price * $cart->quantity;
            $cart->save();
            $grandTotal = Cart::where('user_id', auth()->user()->id)->where('order_number', NULL)->sum('total');

        // For guest users
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->where('id', $thisGuest->id)->first();

            $cart = GuestCart::findOrFail($id);
            $cart->quantity = (int)$request->quantity;
            $cart->total =  $cart->product->price * $cart->quantity;
            $cart->save();
            $grandTotal = GuestCart::where('guest_user_id', $guest->id)->where('order_number', NULL)->sum('total');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Quantity updated successfully.',
            'cart' => $cart,
            'grandTotal' => $grandTotal
        ]);
    }

    public function removeCartItem(Request $request, $id)
    {

        $grandTotal = 0;
        if (auth()->check()) {
            $cart = Cart::findOrFail($id);
            $userId = auth()->user()->id;
            $cart->delete();
            $userCart = Cart::where('user_id', $userId)->where('order_number', NULL)->get();

            $grandTotal = $userCart->sum('total');
            $cartCount = $userCart->count();
        } else {
            $identifier = $request->cookie('device_identifier');
            $thisGuest = GuestUser::where('guest_identifier', $identifier)->first();
            $guest = GuestUser::with('guest_cart.product')->where('id', $thisGuest->id)->first();

            $cart = GuestCart::findOrFail($id);
            $cart->delete();
            $guestCart = GuestCart::where('guest_user_id', $guest->id)->where('order_number', NULL)->get();

            $grandTotal = $guestCart->sum('total');
            $cartCount = $guestCart->count();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cart item removed successfully.',
            'grandTotal' => $grandTotal,
            'cartCount' => $cartCount
        ]);
    }
}
