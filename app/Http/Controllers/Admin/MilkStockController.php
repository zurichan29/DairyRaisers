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
            $activity_logs = ActivityLog::where('type', 'Milk')->get();
            return view('admin.buffalos.index', compact('activity_logs'));
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

            $this->logActivity('Milk data is updated from 5 to 10 liters', $request);

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
        if ($request->is('submit.milk_stock')) {
            return 'Milk';
        } elseif ($request->is('admin/buffalos/store')) {
            return 'Buffalo';
        } else {
            return 'Others';
        }
    }
}
