<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\GuestCart;
use App\Models\GuestOrder;

class OrderController extends Controller
{
    //
    public function show(Request $request)
    {
        $user_order = [];
        if (auth()->check()) {

            $user = User::with('cart.product')->with('order')->with('address')->where('id', auth()->user()->id)->first();
            $orders = $user->order->where('status', '<>', 'delivered');

            if ($orders) {
                foreach ($orders as $order) {
                    $cartItems = $user->cart->where('order_number', $order->order_number);
                    $user_order[$order->id] = [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'full_name' => $user->first_name . ' ' . $user->last_name,
                        'mobile_number' => $user->mobile_number,
                        'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y-m-d g:i A'),
                        'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y-m-d g:i A'),
                        'address' => $order->user_address,
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

        return view('client.order.show', ['user_order' => $user_order]);
    }
}
