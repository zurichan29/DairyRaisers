<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buffalo;
use App\Models\MilkStock;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;

class BuffaloController extends Controller
{
    public function submitBuffalo(Request $request) {
        if (auth()->guard('admin')->check()) {
            $validatedData = $request->validate([
                'gender' => 'required|string',
                'age' => 'required|integer',
                'quantity_sold' => 'required|integer',
                'date_sold' => 'required|date',
                'buyers_name' => 'required|string',
                'buyers_address' => 'required|string',
            ]);

            // Create and save the MilkStock model instance
            $buffalo = new Buffalo();
            $buffalo->gender = $request->gender;
            $buffalo->age = $request->age;
            $buffalo->quantity_sold = $request->quantity_sold;
            $buffalo->date_sold = $request->date_sold;
            $buffalo->buyers_name = $request->buyers_name;
            $buffalo->buyers_address = $request->buyers_address;
            $buffalo->save();

            $this->logActivity($buffalo->quantity_sold . ' of ' . $buffalo->gender . ' Buffalo/s in age/s ' . $buffalo->age . ' added', $request);

            // Optionally, you can add a success message or redirect to another page
            return response()->json($buffalo);
        }
    }

    public function sell(Request $request) {
        if (auth()->guard('admin')->check()) {
            $validatedData = $request->validate([
                'gender' => 'required|string',
                'age' => 'required|integer',
                'quantity_sold' => 'required|integer',
                'date_sold' => 'required|date',
                'buyers_name' => 'required|string',
                'buyers_address' => 'required|string',
            ]);

            // Create and save the MilkStock model instance
            $buffalo = new Buffalo();
            $buffalo->gender = $request->gender;
            $buffalo->age = $request->age;
            $buffalo->quantity_sold = $request->quantity_sold;
            $buffalo->date_sold = $request->date_sold;
            $buffalo->buyers_name = $request->buyers_name;
            $buffalo->buyers_address = $request->buyers_address;
            $buffalo->save();

            $this->logActivity($buffalo->quantity_sold . ' of Buffalo/s sold', $request);

            // Optionally, you can add a success message or redirect to another page
            return response()->json($buffalo);
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
            if ($request->is('admin/buffalos/update')) {
                return 'Update Buffalo';
            } elseif ($request->is('admin/buffalos/sell')) {
                return 'Sell Buffalo';
            } else {
                return 'Others';
            }
        }
}
