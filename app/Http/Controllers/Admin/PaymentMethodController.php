<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    public function create()
    {
        if (auth()->guard('admin')->check()) {

            return view('admin.payment_methods.create');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $payment_methods = PaymentMethod::all();

            return view('admin.payment_methods.index', compact('payment_methods'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }


    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            // Validate the form input
            $validatedData = $request->validate([
                'type' => 'required',
                'account_name' => 'required',
                'account_number' => 'required',
            ]);

            // Create a new PaymentMethod instance
            $paymentMethod = new PaymentMethod;
            $paymentMethod->type = $validatedData['type'];
            $paymentMethod->account_name = $validatedData['account_name'];
            $paymentMethod->account_number = $validatedData['account_number'];
            $paymentMethod->status = 'ACTIVATED';
            // Add any other necessary fields

            // Save the PaymentMethod to the database
            $paymentMethod->save();

            // Return a response or redirect as needed
            return response()->json([
                'message' => 'Payment method successfully added',
                'type' => $validatedData['type'],
                'account_name' => $validatedData['account_name'],
                'account_number' => $validatedData['account_number'],
                'status' => 'ACTIVATED',
                'id' => $paymentMethod->id,
            ]);
        }
    }

    public function delete(Request $request) {
        if (auth()->guard('admin')->check()) {
            $id = $request->input('id');
            $paymentMethod = PaymentMethod::where('id', $id)->first();
            $paymentMethod->delete();
            return response(['message' => 'success', 'id' => $id]);
        }
    }

    public function status(Request $request) {
        if (auth()->guard('admin')->check()) {
            $id = $request->input('id');
            $paymentMethod = PaymentMethod::where('id', $id)->first();
            ($paymentMethod->status == 'ACTIVATED') ? $status = 'DEACTIVATED' : $status = 'ACTIVATED';
            $paymentMethod->status = $status;
            $paymentMethod->save();
            return response(['message' => 'success', 'id' => $id, 'status' => $status]);
        }
    }

    public function update(Request $request) {
        if (auth()->guard('admin')->check()) {
            $id = $request->input('payment_method_id');
            $paymentMethod = PaymentMethod::where('id', $id)->first();
            $paymentMethod->type = $request->input('type');
            $paymentMethod->account_name = $request->input('account_name');
            $paymentMethod->account_number = $request->input('account_number');
            $paymentMethod->save();
            return response([
                'message' => 'success', 
                'id' => $id,
                'type' => $request->input('type'),
                'account_name' => $request->input('account_name'),
                'account_number' => $request->input('account_number'),
                'status' => $paymentMethod->status,

            ]);
        }
    }
}
