<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\PaymentReciept;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use App\Mail\RejectedMailNotif;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{
    //
    public function send() {
        $orderData = [
            'order_number' => 2345,
            'created_at' => 'today',
            'remarks' => 'invalid ammount'
        ];
        Mail::to('christianjayjacalne@gmail.com')->send(new RejectedMailNotif($orderData));
    }
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
            return view('admin.orders.show', compact('order', 'user', 'cart', 'statusBadge'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function approved($id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Pending') {
                $order->status = 'Approved';
                $order->save();
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function onTheWay($id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Approved') {
                $order->status = 'On The Way';
                $order->save();
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function delivered($id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'On The Way') {
                $order->status = 'Delivered';
                $order->save();
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function reject(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            $request->validate([
                'remarks' => ['required', 'max:255'],
            ]);
            if ($order->status == 'Pending') {
                $user = User::where('id', $order->user_id)->first();
                $order->status = 'Rejected';
                $order->comments = $request->input('remarks');
                $order->save();
                // $payment_reciept = PaymentReciept::where('order_id', $id)->first();
                // $payment_reciept->status = 'Rejected';
                // $payment_reciept->save();

                $orderData = [
                    'order_number' => $order->order_number,
                    'created_at' => $order->created_at,
                    'reference_number' => $order->reference_number,
                    'comments' => $order->comments,
                    'first_name' => $user->first_name,
                ];
                Mail::to($user->email)->send(new RejectedMailNotif($orderData));

                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function grant(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            $request->validate([
                'remarks' => ['required', 'max:255'],
            ]);
            if ($order->status == 'Rejected') {
                $order->status = 'Approved';
                $order->comments = $request->input('remarks');
                $order->save();
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }
}
