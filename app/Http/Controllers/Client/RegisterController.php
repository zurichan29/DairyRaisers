<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\User;

class RegisterController extends Controller
{
    //
    public function show()
    {
        return view('client.register.show');
    }

    public function checkMobileNum(Request $request)
    {
        if (!auth()->check()) {

            $number = $request->input('number');
            $country_code = '+63'; // Country code to be removed
            $number = str_replace($country_code, '', $number);
            $user = User::where('mobile_number', $number)->first();

            if ($user) {
                return response()->json([
                    'status' => 'verified'
                ]);
            } else {
                return response()->json([
                    'status' => 'unverified'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function InputMobileNum(Request $request)
    {
        $user = User::where('mobile_number', $request->input('number'))->first();
        if (!$user && !auth()->check()) {
            session(['register.mobile_number' => $request->input('number')]);

            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }

    // public function showVerifyOTPForm()
    // {
    //     $user = User::where('mobile_number', session('register.mobile_number'))->first();
    //     if (!$user && !auth()->check() && session()->exists('register.mobile_number') && session('register.mobile_verified_at') == null) {
    //         return view('client.register.VerifyOTPForm');
    //     }

    //     throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    // }

    // public function checkOTP(Request $request)
    // {
    //     $user = User::where('mobile_number', session('register.mobile_number'))->first();
    //     if (!$user && !auth()->check() && session()->exists('register.mobile_number') && session('register.mobile_verified_at') == null) {

    //         $credential = $request->validate([
    //             'otp' => ['required', 'numeric', 'min:4'],
    //         ]);

    //         $otp = $request->input('otp');

    //         if (session('register.verify_otp_cooldown') != null && session('register.verify_otp_cooldown') <= Carbon::now()) {

    //             session()->put('register.verify_otp_cooldown', null);
    //             session()->put('register.otp_count', 0);
    //         }

    //         // Validate if the mobile 
    //         if (session('register.otp_count') < 3) {
    //             if (session('register.otp_expires_at') <= Carbon::now()) {
    //                 throw ValidationException::withMessages([
    //                     'otp' => 'Your OTP expired. Please resend a new OTP',
    //                 ]);
    //             }
    //             if (session('register.mobile_verify_otp') == $otp) {

    //                 session()->put('register.otp_expires_at', null);
    //                 session()->put('register.verify_otp_cooldown', null);
    //                 session()->put('register.otp_count', 0);
    //                 session()->put('register.resend_attempt', 0);
    //                 session()->put('register.resend_otp_cooldown', null);
    //                 session()->put('register.mobile_verified_at', Carbon::now());
    //                 session()->put('register.details', true);

    //                 /** GO TO REGISTER DETAILS */
    //                 return redirect()->route('register.details');
    //             }
    //             session()->put('register.otp_count', session('register.otp_count') + 1);

    //             throw ValidationException::withMessages([
    //                 'otp' => 'Incorrect OTP input',
    //             ]);
    //         }

    //         if (session('register.verify_otp_cooldown') == null) {
    //             session()->put('register.verify_otp_cooldown', Carbon::now()->addMinutes(10));
    //         }

    //         $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', session('register.verify_otp_cooldown'))->format('Y-m-d g:i A');

    //         throw ValidationException::withMessages([
    //             'otp' => 'Too many otp verify attempt. Please wait in ' . $remainingTime,
    //         ]);
    //     } else {
    //         throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    //     }
    // }

    // public function resendOTP()
    // {
    //     $otp = rand(1000, 9999);
    //     $user = User::where('mobile_number', session('register.mobile_number'))->first();
    //     if (!$user && !auth()->check() && session()->exists('register.mobile_number') && session('register.mobile_verified_at') == null) {

    //         if (session('register.otp_resend_cooldown') != null && session('register.otp_resend_cooldown') <= Carbon::now()) {
    //             session()->put('register.otp_resend_cooldown', null);
    //             session()->put('register.otp_resend_attempt', 0);
    //         }

    //         if (session('register.otp_resend_attempt') < 3) {
    //             session()->put('register.mobile_verify_otp', $otp);
    //             session()->put('register.otp_resend_attempt', session('register.otp_resend_attempt') + 1);
    //             session()->put('register.otp_expires_at', Carbon::now()->addMinutes(10));

    //             return redirect()->back()->with('message', 'resend code successfully sent');
    //         }

    //         if (session('register.otp_resend_cooldown') == null) {
    //             session()->put('register.otp_resend_cooldown', Carbon::now()->addMinutes(60));
    //         }

    //         $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', session('otp_resend_cooldown'))->format('Y-m-d g:i A');

    //         return redirect()->back()->with('resend_otp', 'You have reach maximum otp resend. Please wait in ' . $remainingTime);
    //     }

    //     throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    // }

    public function showDetailsForm($mobile_number)
    {
        $user = User::where('mobile_number', $mobile_number)->first();
        if (!$user && !auth()->check() && session()->exists('register.mobile_number')) {
            return view('client.register.RegisterDetailsForm', ['mobile_number' => $mobile_number]);
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkDetails(Request $request)
    {
        $user = User::where('mobile_number', session('register.mobile_number'))->first();
        if (!$user && !auth()->check() && session()->exists('register.mobile_number')) {
            $request->validate([
                'first_name' => ['required', 'string', 'min:5'],
                'last_name' => ['required', 'string', 'min:5'],
                'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ], [
                'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
            ]);
            $user = new User();
            $user->mobile_number = session('register.mobile_number');
            $user->mobile_verified_at = Carbon::now();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            session()->forget('register.mobile_number');

            // Log in the user automatically
            Auth::login($user);

            return redirect('/')->with('message', 'Register Done and automatically log in');
        }

        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }
}
