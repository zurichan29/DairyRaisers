<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\PaymentReciept;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Mail\RejectedMailNotif;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $orders = Order::with('user')->get()->sortBy('created_at');

            return view('admin.orders.index', compact('orders'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function ref(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'ref' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $order = Order::findOrFail($request->input('order_id'));
            $order->reference_number = $request->input('ref');
            $order->save();

            $validatedData = $validator->validated();
            $data = [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'ref' => $request->input('ref')
            ];

            return response()->json($data);
        } else {
        }
    }

    public function fetch(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $order = Order::findOrFail($request->input('order_id'));

            $data = [
                // 'order_id' => $order->id,
                // 'order_number' => $order->order_number,
                'ref' => $order->reference_number
            ];

            return response()->json($data);
        }
    }

    public function show($id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            $user = User::with('cart.product')->with('order')->with('address')->where('id', $order->user->id)->first();
            $cart = $user->cart->where('order_number', $order->order_number);
            $statusBadge = null;
            if ($order->delivery_option == 'Delivery') {
            } elseif ($order->delivery_option == 'Pick Up') {
            }
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
            return redirect()->route('login.administrator');
        }
    }

    public function approved(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Pending') {
                $order->status = 'Approved';
                $order->save();
                $this->logActivity('Administrator updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function onTheWay(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Approved') {
                $order->status = 'On The Way';
                $order->save();
                $this->logActivity('Administrator updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function pickUp(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Approved') {
                $order->status = 'Ready To Pick Up';
                $order->save();
                $this->logActivity('Administrator updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function delivered(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'On The Way') {
                $order->status = 'Delivered';
                $order->save();
                $this->logActivity('Administrator updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } elseif ($order->status == 'Ready To Pick Up') {
                $order->status = 'Recieved';
                $order->save();
                $this->logActivity('Administrator updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('login.administrator');
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
                $this->logActivity('Administrator updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    // Method to log the activity
    private function logActivity($activityDescription, $request)
    {
        if (auth()->guard('admin')->check()) {
            $activityLog = new ActivityLog([
                'admin_id' => auth()->guard('admin')->user()->id,
                'activity_type' => $this->getActivityType($request),
                'description' => $activityDescription,
                'ip_address' => $request->ip(),
            ]);

            $activityLog->save();
        }
    }

    private function getActivityType($request)
    {
        if ($request->is('admin/orders/{id}/approved')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/otw')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/pickup')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/delivered')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/reject')) {
            return 'Orders';
        }  else {
            return 'Others';
        }
    }
}
