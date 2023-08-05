<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\ActivityLog;
use App\Mail\VerifyStaffEmail;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    //

    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $staffs = Admin::all();
            $accessList = [
                'staff_management',
                'buffalo_management',
                'inventory',
                'orders',
                'payment_methods',
                'activity_logs',
                'sales_report',
            ];

            return view('admin.staffs.index', compact('staffs', 'accessList'));
        }
    }

    public function init()
    {
        $staffs = Admin::where('is_admin', false)->get();
        return  response()->json($staffs);
    }

    public function fetch(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $staff = Admin::findOrFail($request->staff_id);

            // Convert the staff's access to an array if it's not already an array
            $staffAccess = is_array($staff->access) ? $staff->access : json_decode($staff->access, true);

            return response()->json([
                'staff' => $staff,
                'staffAccess' => $staffAccess,
            ]);
        }
    }

    public function update(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $validator = Validator::make($request->all(), [
                'staff_id' => 'required',
                'name' => 'required',
                'access' => ['required', 'array'],
                'access.*' => 'in:inventory,orders,products,buffalos_and_milk,staff_management,activity_logs,payment_methods,sales_report',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $staff = Admin::where('id', $request->staff_id)->first();
            $staff->name = $request->name;
            $staff->access = json_encode($request->access);
            $staff->save();

            $this->logActivity(auth()->guard('admin')->user()->name . ' update name and access of : ' . $staff->id, $request);

            return response()->json($staff);
        }
    }

    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:admin,email|email',
                'access' => ['required', 'array'],
                'access.*' => 'in:inventory,orders,products,buffalos_and_milk,staff_management,activity_logs,sales_report,payment_methods',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $staff = new Admin;
            $staff->name = $request->name;
            $staff->email = $request->email;
            $staff->access = json_encode($request->access); // Convert the access array to a comma-separated string
            $staff->is_verified = false; // Set is_verified to false since the email is not verified yet
            $staff->verification_token = Str::random(40); // Generate a random verification token
            $staff->save();

            Mail::to($staff->email)->send(new VerifyStaffEmail($staff));
            $this->logActivity(auth()->guard('admin')->user()->name . ' added a new staff: ' . $staff->id, $request);

            return response()->json($staff);
        }
    }

    public function showPasswordSetupForm($token)
    {
        $staff = Admin::where('verification_token', $token)->where('is_verified', false)->first();

        if (!$staff) {
            abort(404); // Or redirect to an error page
        }

        return view('admin.staffs.password_setup', compact('token'));
    }

    public function setupPassword(Request $request, $token)
    {
        $staff = Admin::where('verification_token', $token)->where('is_verified', false)->first();

        if (!$staff) {
            abort(404); // Or redirect to an error page
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $staff->password = Hash::make($request->password);
        $staff->is_verified = true;
        $staff->verification_token = null;
        $staff->save();

        // You may add a success message here if desired.

        return redirect()->route('login.administrator'); // Redirect to the login page or any other page.
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
        if ($request->is('admin/staff')) {
            return 'Staff';
        } else {
            return 'Others';
        }
    }
}
