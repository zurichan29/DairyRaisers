<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\DeliveryFee;
use Illuminate\Support\Facades\Validator;

class DeliveryFeeController extends Controller
{
    //

    public function index()
    {
        $delivery_fees = DeliveryFee::all();
        return view('admin.orders.delivery_fee', compact('delivery_fees'));
    }

    public function data()
    {
        $delivery_fees = DeliveryFee::all();
        return response()->json($delivery_fees);
    }

    public function get(Request $request)
    {
        $delivery_fee = DeliveryFee::findOrFail($request->input('fee_id'));
        if ($delivery_fee) {
            return response()->json($delivery_fee);
        } else {
            return response()->json(['error' => 'municipality no found.'], 400);
        }
    }

    public function update(Request $request)
    {
        $delivery_fee = DeliveryFee::findOrFail($request->input('fee_id'));
        if ($delivery_fee) {
            $validator = Validator::make($request->all(), [
                'fee' => 'numeric|min:1',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $delivery_fee->fee = $request->input('fee');
            $delivery_fee->save();

            $this->logActivity(auth()->guard('admin')->user()->name . ' updated the delivery charge of ' . $delivery_fee->municipality . ' : ' . $delivery_fee->fee . '.', $request);
            return response()->json($delivery_fee);
        } else {
            return response()->json(['error' => 'municipality no found.'], 400);
        }
    }


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
        return 'Delivery Fees';
    }
}
