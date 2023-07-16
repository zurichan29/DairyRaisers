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
    //
    public function index(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            

            $payment_methods = PaymentMethod::all();

            return view('admin.payment_methods.index', compact('payment_methods'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function tables()
    {
    }
}
