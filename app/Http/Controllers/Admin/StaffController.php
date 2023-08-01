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

            return view('admin.staffs.index', compact('staffs'));
        }
    }

    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:admin,email|email',
                'access' => ['required', 'array'],
                'access.*' => 'in:inventory,orders,products,buffalos_and_milk,staff_management,activity_logs,payment_methods',
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
}
