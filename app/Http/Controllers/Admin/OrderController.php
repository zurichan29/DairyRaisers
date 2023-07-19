<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $orders = Order::with('user')->get();

            return view('admin.orders.index', compact('orders'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function show($id)
    {
        
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            $user = User::with('cart.product')->with('order')->with('address')->where('id', $order->user->id)->first();
            $cart = $user->cart->where('order_number', $order->order_number);
            $statusBadge = null;
            $icon = null;
            switch ($order->status) {
                case 'Pending':
                    $statusBadge = 'badge-info';
                    $icon = '<i class="fa-solid fa-circle-info"></i>';
                    break;
                
                default:
                    break;
            }
            return view('admin.orders.show', compact('order', 'user', 'cart', 'statusBadge', 'icon'));
            
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }
}
