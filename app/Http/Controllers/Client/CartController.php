<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;

class CartController extends Controller
{
    public function cart()
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
                        'product_id' => $cartItem->product->id,
                        'name' => $cartItem->product->name,
                        'img' => $cartItem->product->img,
                        'variant' => $cartItem->product->variant->name,
                        'price' => $cartItem->product->price,
                        'quantity' => $cartItem->quantity,
                        'total' => $total
                    ];
                    $grand_total += $total;
                }
            }
        } else {
            $userCart = session('order_data');

            if (session()->has('order_data')) {
                foreach ($userCart as $item) {
                    $grand_total += $item['total'];
                }
            }
        }


        return view('client.shop.cart', ['cart' => $userCart, 'grand_total' => $grand_total]);
    }

    public function updateQuantity(Request $request)
    {

        $grandTotal = 0;
        $total = 0;
        $item_quantity = 0;
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->input('cartId'))->first();
            if ($request->input('math_method') == 'increase') {
                $cart->quantity += 1;
            } else if ($request->input('math_method') == 'decrease') {
                $cart->quantity -= 1;
            } else {
                return response()->json("error invalid math method", 400);
            }
            $item_quantity = $cart->quantity;
            $cart->total = $cart->product->price * $cart->quantity;
            $cart->save();
            $total = $cart->total;
            $grandTotal = Cart::where('user_id', auth()->user()->id)->get()->sum('total');
        } else {
            $orderData = session('order_data', []);
            $total = 0;

            if (session()->has('order_data')) {
                $existingProductIndex = null;
                foreach ($orderData as $index => $item) {
                    if ($item['product_id'] == $request->input('cartId')) {
                        $existingProductIndex = $index;
                        break;
                    }
                }

                if ($existingProductIndex !== null) {
                    if ($request->input('math_method') == 'increase') {
                        $orderData[$existingProductIndex]['quantity'] += 1;
                    } else if ($request->input('math_method') == 'decrease') {
                        $orderData[$existingProductIndex]['quantity'] -= 1;
                    } else {
                        return response()->json("error invalid math method", 400);
                    }
                    $item_quantity = $orderData[$existingProductIndex]['quantity'];
                    $orderData[$existingProductIndex]['total'] = $orderData[$existingProductIndex]['price'] * $orderData[$existingProductIndex]['quantity'];

                    session(['order_data' => $orderData]);

                    $cartTotal = 0;
                    foreach (session('order_data') as $item) {
                        $cartTotal += $item['total'];
                    }

                    $total = $orderData[$existingProductIndex]['total'];
                }

                $grandTotal = 0;
                foreach ($orderData as $item) {
                    $grandTotal += $item['total'];
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Quantity updated successfully.',
            'item_quantity' => $item_quantity,
            'total' => $total,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function removeCart(Request $request)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->input('cartId'))->first();
            $cart->delete();
            // $cart->save();
            $carts = Cart::where('user_id', auth()->user()->id)->get();
            $count = $carts->count();
            $grandTotal = $carts->sum('total');
        } else {
            $cartId = $request->input('cartId');
            $orderData = session('order_data', []);
            
            if ($orderData) {
                $removedProductIndex = null;
                foreach ($orderData as $index => $item) {
                    
                    if ($item['product_id'] == $cartId) {
                        $removedProductIndex = $index;
                        break;
                    }
                }
                if ($removedProductIndex !== null) {
                    
                    $removedTotal = $orderData[$removedProductIndex]['total'];
                    unset($orderData[$removedProductIndex]); // Remove the product from the array
                    session(['order_data' => $orderData]);

                    $grandTotal = 0;
                    foreach ($orderData as $item) {
                        $grandTotal += $item['total'];
                    }

                    $count = count(session('order_data'));
                } else {
                    return response()->json(['error' => 'no index found'], 400);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item not found in the cart.'
                ], 404);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed successfully.',
            'grandTotal' => $grandTotal,
            'count' => $count,
        ]);
    }
}
