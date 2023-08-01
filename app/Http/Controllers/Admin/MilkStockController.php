<?php

namespace App\Http\Controllers\Admin;

use App\Models\MilkStock;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MilkStockController extends Controller
{
    //
    public function index()
    {
        // Your logic here
        if (auth()->guard('admin')->check()) {
            $activity_logs = ActivityLog::where('activity_type', 'Milk')->get();
            $milkStock = MilkStock::where('quantity')->count();
            $liters = MilkStock::all()->sum('quantity');
            
            return view('admin.buffalos.index', compact('activity_logs','milkStock', 'liters'));
        } else {
            return redirect()->back();
        }
    }


    public function submitMilkStock(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validatedData = $request->validate([
                'date_created' => 'required|date',
                'quantity' => 'required|integer',
            ]);

            // Create and save the MilkStock model instance
            $milkStock = new MilkStock();
            $milkStock->date_created = $request->date_created;
            $milkStock->quantity = $request->quantity;
            $milkStock->save();

            $this->logActivity($milkStock->quantity . ' Milk/s added in stock', $request);

            // Optionally, you can add a success message or redirect to another page
            return response()->json($milkStock);
        }
    }

    public function sell(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validatedData = $request->validate([
                'date_created' => 'required|date',
                'quantity' => 'required|integer',
            ]);

            // Create and save the MilkStock model instance
            $milkStock = MilkStock::where('created_at', $request->created_at)->first();
            $milkStock->date_created = $request->date_created;
            $milkStock->quantity = $milkStock->quantity + $request->quantity;
            $milkStock->save();

            $this->logActivity($milkStock->quantity . ' of Milk/s sold', $request);

            // Optionally, you can add a success message or redirect to another page
            return response()->json($milkStock);
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
        if ($request->is('admin/milk/update')) {
            return 'Update Milk';
        } elseif ($request->is('admin/milk/sell')) {
            return 'Sell Milk';
        } else {
            return 'Others';
        }
    }
}