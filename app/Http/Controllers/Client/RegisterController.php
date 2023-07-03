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
        return view('client.page.register.show');
    }

    public function checkMobileNum(Request $request)
    {
        if (!auth()->check()) {

            $user = User::where('mobile_number', $request->input('number'))->first();

            if ($user) {
                if ($user->password == NULL) {
                    return response()->json([
                        'status' => 'no data'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'verified'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'unverified'
                ]);
            }








            // $request->validate([
            //     'mobile_number' => ['required', 'numeric', 'regex:/^9[0-9]{9}$/'],
            // ], [
            //     'mobile_number.regex' => 'The :attribute must be a valid phone number with 10 characters and starting with 9.',
            // ]);

            // $user = User::where('mobile_number', $request->input('mobile_number'))->whereNotNull('mobile_verified_at')->first();

            // if ($user == null) {
            //     // Mobile number is registered or not yet verified
            //     // User will be redirect to another page to verify the registered mobile number
            //     $otp = rand(1000, 9999);
            //     $mobile_number = $request->input('mobile_number');
            //     if (session()->exists('register.details')) {
            //         return redirect()->route('register.reset');
            //     }

            //     if (!session()->exists('register.mobile_number')) {

            //         $message = "This is your OTP code: $otp. NEVER share the code to anyone.";

            //         if (session('register.mobile_number') != $mobile_number) {
            //             session()->remove('register.mobile_number');
            //         }
            //         session()->put('register.mobile_number', $request->input('mobile_number'));
            //         session()->put('register.mobile_verify_otp', $otp);
            //         session()->put('register.otp_expires_at', Carbon::now()->addMinutes(10));
            //         session()->put('register.verify_otp_cooldown', null);
            //         session()->put('register.resend_otp_cooldown', null);
            //         session()->put('register.mobile_verified_at', null);
            //         session()->put('register.otp_count', 0);
            //         session()->put('register.otp_resend_attempt', 0);
            //     }
            //     return redirect()->route('register.verify-otp');
            // }

            // throw ValidationException::withMessages([
            //     'mobile_number' => 'The mobile number is already registered and verified',
            // ]);
        } else {
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function InputMobileNum(Request $request)
    {
        $user = User::where('mobile_number', $request->input('number'))->first();
        if (!$user && !auth()->check()) {
            $new_user = New User;
            $new_user->mobile_number = $request->input('number');
            $new_user->mobile_verified_at = Carbon::now();
            $new_user->save();

            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }

    public function showVerifyOTPForm()
    {
        $user = User::where('mobile_number', session('register.mobile_number'))->first();
        if (!$user && !auth()->check() && session()->exists('register.mobile_number') && session('register.mobile_verified_at') == null) {
            return view('client.page.register.VerifyOTPForm');
        }

        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkOTP(Request $request)
    {
        $user = User::where('mobile_number', session('register.mobile_number'))->first();
        if (!$user && !auth()->check() && session()->exists('register.mobile_number') && session('register.mobile_verified_at') == null) {

            $credential = $request->validate([
                'otp' => ['required', 'numeric', 'min:4'],
            ]);

            $otp = $request->input('otp');

            if (session('register.verify_otp_cooldown') != null && session('register.verify_otp_cooldown') <= Carbon::now()) {

                session()->put('register.verify_otp_cooldown', null);
                session()->put('register.otp_count', 0);
            }

            // Validate if the mobile 
            if (session('register.otp_count') < 3) {
                if (session('register.otp_expires_at') <= Carbon::now()) {
                    throw ValidationException::withMessages([
                        'otp' => 'Your OTP expired. Please resend a new OTP',
                    ]);
                }
                if (session('register.mobile_verify_otp') == $otp) {

                    session()->put('register.otp_expires_at', null);
                    session()->put('register.verify_otp_cooldown', null);
                    session()->put('register.otp_count', 0);
                    session()->put('register.resend_attempt', 0);
                    session()->put('register.resend_otp_cooldown', null);
                    session()->put('register.mobile_verified_at', Carbon::now());
                    session()->put('register.details', true);

                    /** GO TO REGISTER DETAILS */
                    return redirect()->route('register.details');
                }
                session()->put('register.otp_count', session('register.otp_count') + 1);

                throw ValidationException::withMessages([
                    'otp' => 'Incorrect OTP input',
                ]);
            }

            if (session('register.verify_otp_cooldown') == null) {
                session()->put('register.verify_otp_cooldown', Carbon::now()->addMinutes(10));
            }

            $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', session('register.verify_otp_cooldown'))->format('Y-m-d g:i A');

            throw ValidationException::withMessages([
                'otp' => 'Too many otp verify attempt. Please wait in ' . $remainingTime,
            ]);
        } else {
            throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function resendOTP()
    {
        $otp = rand(1000, 9999);
        $user = User::where('mobile_number', session('register.mobile_number'))->first();
        if (!$user && !auth()->check() && session()->exists('register.mobile_number') && session('register.mobile_verified_at') == null) {

            if (session('register.otp_resend_cooldown') != null && session('register.otp_resend_cooldown') <= Carbon::now()) {
                session()->put('register.otp_resend_cooldown', null);
                session()->put('register.otp_resend_attempt', 0);
            }

            if (session('register.otp_resend_attempt') < 3) {
                session()->put('register.mobile_verify_otp', $otp);
                session()->put('register.otp_resend_attempt', session('register.otp_resend_attempt') + 1);
                session()->put('register.otp_expires_at', Carbon::now()->addMinutes(10));

                return redirect()->back()->with('message', 'resend code successfully sent');
            }

            if (session('register.otp_resend_cooldown') == null) {
                session()->put('register.otp_resend_cooldown', Carbon::now()->addMinutes(60));
            }

            $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', session('otp_resend_cooldown'))->format('Y-m-d g:i A');

            return redirect()->back()->with('resend_otp', 'You have reach maximum otp resend. Please wait in ' . $remainingTime);
        }

        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function showDetailsForm($mobile_number)
    {
        $user = User::where('mobile_number', $mobile_number)->where('password', NULL)->first();
        if ($user && !auth()->check()) {
            return view('client.page.register.RegisterDetailsForm', ['mobile_number' => $mobile_number]);
        }
        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkDetails(Request $request)
    {
        $user = User::where('mobile_number', $request->input('mobile_number'))->where('password', NULL)->first();
        if ($user && !auth()->check()) {
            $request->validate([
                'first_name' => ['required', 'string', 'min:5'],
                'last_name' => ['required', 'string', 'min:5'],
                'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ], [
                'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
            ]);

            $user->mobile_verified_at = Carbon::now();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // Log in the user automatically
            Auth::login($user);

            return redirect('/')->with('message', 'Register Done and automatically log in');
        }

        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }
}
