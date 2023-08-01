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

class ProfileController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $profile = Admin::where('id', auth()->guard('admin')->user()->id)->first();

            return view('admin.profile.index', compact('profile'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function update(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'current_password' => 'required',
                'new_password' => 'required|min:6|different:current_password|confirmed',
            ]);

            $user = Admin::where('id', auth()->guard('admin')->user()->id)->first();

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('admin.profile.index')->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            $user->name = $request->name;
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('admin.profile.index');
        } else {
            return redirect()->route('login.administrator');
        }
    }
}
