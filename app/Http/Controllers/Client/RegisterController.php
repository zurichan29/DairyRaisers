<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class RegisterController extends Controller
{
    //
    public function show()
    {

        return view('client.register.email');
    }

    public function validation(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'min:4'],
            'last_name' => ['required', 'string', 'min:4'],
            'email' => ['required', 'email', 'unique:users,email'],
            'mobile_number' => ['required', 'integer', 'digits:10', 'regex:/^9/'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ], [
            'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
        ]);

        $user = new User();
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->email_verify_token = Str::random(60);
        $user->mobile_verified_at = Carbon::now();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('register')->with('message', [
            'type' => 'success',
            'title' => 'Verify Your Email',
            'body' => 'An email confirmation was sent to your email address. Please check your inbox.',
            'period' => true,
        ]);
    }

    public function email_validate(Request $request, $token, $email)
    {
        $user = User::where('email_verify_token', $token)->where('email_verified_at', null)->where('email', $email)->first();

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->email_verify_token = null;
            $user->save();

            if(auth()->check()) {
                auth()->logout();
            }

            //LOGGED IN THE USER
            auth()->login($user);

            return redirect()->route('index')->with('message', [
                'type' => 'success',
                'title' => 'Verified',
                'body' => 'Your email has been successfully validated.',
                'period' => true,
            ]);
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function resend_token()
    {
        return view('client.register.resend-token');
    }

    public function send_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)
                        ->whereNull('email_verified_at')
                        ->first();

                    if (!$user) {
                        $fail("The provided email is not valid or is already verified.");
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user = User::where('email', $request->email)->first();

        if ($user->email_code_count >= 3 && Carbon::now() >= $user->email_code_cooldown) {
            $user->email_code_count = 0;
            $user->email_code_cooldown =  null;
            $user->save();
        }

        // Check if the user has exceeded the resend limit
        if ($user->email_code_count >= 3 && Carbon::now()->lt($user->email_code_cooldown)) {
            return response()->json(['error' => 'You have used up all of your attempts to resend email verification. Please wait a moment and try again.'], 422);
        }

        // Update email_code_count and email_code_cooldown
        $user->email_code_count = $user->email_code_count + 1;
        if ($user->email_code_count >= 3) {
            $user->email_code_cooldown = Carbon::now()->addHour();
        }
        $user->email_verify_token = Str::random(40);
        $user->save();

        Mail::to($user->email)->send(new VerifyEmail($user));

        return response()->json(['success' => 'Verification token has been sent to your email. Please check your inbox.']);
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
