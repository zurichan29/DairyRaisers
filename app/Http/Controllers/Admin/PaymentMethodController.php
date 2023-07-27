<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $payment_methods = PaymentMethod::all();

            return view('admin.payment_methods.index', compact('payment_methods'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $validator = Validator::make($request->all(), [
                'type' => 'required|max:255|min:3',
                'account_name' => 'required|max:255|min:3',
                'account_number' => 'required|max:255|min:3',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // Create a new PaymentMethod instance
            $paymentMethod = new PaymentMethod;
            $paymentMethod->type = $request->type;
            $paymentMethod->account_name = $request->account_name;
            $paymentMethod->account_number = $request->account_number;
            $paymentMethod->status = 'ACTIVATED';
            // Add any other necessary fields

            // Save the PaymentMethod to the database
            $paymentMethod->save();

            $this->logActivity('Administrator has added a payment method: ' . $paymentMethod->type, $request);

            // Return a response or redirect as needed
            return response()->json([
                'message' => 'Payment method successfully added',
                'type' => $request->type,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'status' => 'ACTIVATED',
                'id' => $paymentMethod->id,
            ]);
        }
    }

    public function delete(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $id = $request->input('id');
            $paymentMethod = PaymentMethod::where('id', $id)->first();
            $this->logActivity('Administrator has deleted a payment method: ' . $paymentMethod->type, $request);
            $paymentMethod->delete();
            return response(['message' => 'success', 'id' => $id, 'type' => $paymentMethod->type]);
        }
    }

    public function status(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $id = $request->input('id');
            $paymentMethod = PaymentMethod::where('id', $id)->first();
            ($paymentMethod->status == 'ACTIVATED') ? $status = 'DEACTIVATED' : $status = 'ACTIVATED';
            $paymentMethod->status = $status;
            $paymentMethod->save();
            $this->logActivity('Administrator has updated the status of ' . $paymentMethod->type . ' to ' . $paymentMethod->status, $request);

            return response(['message' => 'success', 'id' => $id, 'status' => $status, 'type' => $paymentMethod->type]);
        }
    }

    public function update(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'payment_method_id' => 'required|exists:payment_method,id',
                'type' => 'required|max:255',
                'account_name' => 'required|max:255',
                'account_number' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $id = $request->input('payment_method_id');
            $paymentMethod = PaymentMethod::where('id', $id)->first();
            $paymentMethod->type = $request->input('type');
            $paymentMethod->account_name = $request->input('account_name');
            $paymentMethod->account_number = $request->input('account_number');
            $paymentMethod->save();

            $this->logActivity('Administrator has updated a payment method: ' . $paymentMethod->type, $request);

            return response([
                'message' => 'success',
                'id' => $id,
                'type' => $paymentMethod->type,
                'account_name' => $request->input('account_name'),
                'account_number' => $request->input('account_number'),
                'status' => $paymentMethod->status,

            ]);
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function getPaymentMethodData(Request $request)
    {
        $payment_method = PaymentMethod::all();

        return response()->json($payment_method);
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
        if ($request->is('admin/payment_method/store')) {
            return 'Payment Method';
        } elseif ($request->is('admin/payment_method/delete')) {
            return 'Payment Method';
        } elseif ($request->is('admin/payment_method/status')) {
            return 'Payment Method';
        } elseif ($request->is('admin/payment_method/update')) {
            return 'Payment Method';
        } else {
            return 'Others';
        }
    }
}
