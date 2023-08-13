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
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $profile = Admin::where('id', auth()->guard('admin')->user()->id)->first();
            $accessData = json_decode($profile->access, true); // Convert the JSON data to an array

            return view('admin.profile.index', compact('profile', 'accessData'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function update_password(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|different:current_password|confirmed',
            ]);

            $user = Admin::where('id', auth()->guard('admin')->user()->id)->first();

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('admin.profile.index')->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();
            $this->logActivity(auth()->guard('admin')->user()->name . ' update the password', $request);
            return redirect()->route('admin.profile.index')->with('message', [
                'type' => 'info',
                'body' => 'Your password has been successfully changed. Please keep your new password secure.',
                'title' => 'Password Change Successful',
            ]);

        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function update_avatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg', // Validating the image file
        ]);

        // Get the uploaded file
        $avatar = $request->file('avatar');
        // Generate a unique name for the file
        $fileName = uniqid() . '.' . $avatar->getClientOriginalExtension();

        // Store the file in the public disk under the 'images/avatar' directory
        $path = $avatar->storeAs('public/images/avatar', $fileName);

        // Update the staff's img column with the path to the uploaded image
        $profile = Admin::where('id', auth()->guard('admin')->user()->id)->first();

        $profile->img = $path;
        $profile->save();

        $this->logActivity(auth()->guard('admin')->user()->name . ' update the avatar', $request);

        return redirect()->back()->with('success', 'Avatar updated successfully.');
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
        if ($request->is('admin/profile')) {
            return 'Profile';
        } else {
            return 'Others';
        }
    }
}
