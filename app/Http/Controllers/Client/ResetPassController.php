<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class ResetPassController extends Controller
{
    //

    public function show()
    {
        if (!auth()->check()) {
            return view('client.page.resetPass.show');
        }

        return redirect()->intended('/');
    }

    public function checkMobileNum(Request $request)
    {
        if (!auth()->check()) {
            $request->validate([
                'mobile_number' => ['required', 'numeric', 'regex:/^9[0-9]{9}$/'],
            ]);
            $mobile_number = $request->input('mobile_number');
            $user = User::where('mobile_number', $mobile_number)->first();
            $otp = rand(1000, 9999);
            
            if ($user) {
                /** SEND OTP */
                if (session()->exists('reset_password.change')) {
                    return redirect()->route('forgot_password.reset');
                }

                if (!session()->exists('reset_password.number')) {
                    if (session('reset_password.number') != $mobile_number) {
                        session()->remove('reset_password.number');
                    }
                    session()->put('reset_password.number', $mobile_number);
                    $user->verify_otp_cooldown = null;
                    $user->otp_count = 0;
                    $user->otp_resend_attempt = 0;
                    $user->otp_resend_cooldown = null;
                    $user->mobile_verify_otp = $otp;
                    $user->otp_expires_at = Carbon::now()->addMinutes(10);
                    $user->save();
                }

                return redirect()->route('forgot_password.otp');
            }

            throw ValidationException::withMessages([
                'mobile_number' => 'The provided credentials do not match our records.',
            ])->status(422);
        }
        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function showOTPForm()
    {
        $user = User::where('mobile_number', session('reset_password.number'))->whereNotNull('mobile_verified_at')->first();
        if ($user && !auth()->check()) {
            return view('client.page.resetPass.OTPForm');
        }
        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkOTP(Request $request)
    {
        $user = User::where('mobile_number', session('reset_password.number'))->whereNotNull('mobile_verified_at')->first();
        if ($user && !auth()->check()) {
            $credential = $request->validate([
                'otp' => ['required', 'numeric', 'min:4'],
            ]);

            $otp = $request->input('otp');

            if ($user->verify_otp_cooldown != null && $user->verify_otp_cooldown <= Carbon::now()) {
                $user->verify_otp_cooldown = null;
                $user->otp_count = 0;
                $user->save();
            }

            if ($user->otp_count < 3) {
                if ($user->otp_expires_at <= Carbon::now()) {
                    throw ValidationException::withMessages([
                        'otp' => 'Your OTP expired. Please resend a new OTP',
                    ]);
                }
                if ($user->mobile_verify_otp == $otp) {

                    session()->put('reset_password.change', true);
                    $user->otp_expires_at = null;
                    $user->verify_otp_cooldown = null;
                    $user->otp_count = 0;
                    $user->otp_resend_attempt = 0;
                    $user->otp_resend_cooldown = null;
                    $user->mobile_verified_at = Carbon::now();
                    $user->save();

                    return redirect()->route('forgot_password.reset');
                }

                $user->otp_count = $user->otp_count + 1;
                $user->save();

                throw ValidationException::withMessages([
                    'otp' => 'Incorrect OTP input',
                ]);
            }

            if ($user->verify_otp_cooldown == NULL) {
                $user->verify_otp_cooldown = Carbon::now()->addMinutes(5);
                $user->save();
            }

            $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', $user->verify_otp_cooldown)->format('Y-m-d g:i A');

            throw ValidationException::withMessages([
                'otp' => 'Too many attempt in verifying OTP. Please wait in ' . $remainingTime,
            ]);
        } else {
            throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function resendOTP()
    {
        $otp = rand(1000, 9999);
        $user = User::where('mobile_number', session('reset_password.number'))->whereNotNull('mobile_verified_at')->first();
        if ($user && !auth()->check()) {
            if ($user->otp_resend_cooldown != null && $user->otp_resend_cooldown <= Carbon::now()) {

                $user->otp_resend_cooldown = null;
                $user->otp_resend_attempt = 0;
                $user->save();
            }
            if ($user->otp_resend_attempt < 3) {
                $user->mobile_verify_otp = $otp;
                $user->otp_resend_attempt = $user->otp_resend_attempt + 1;
                $user->otp_expires_at = Carbon::now()->addMinutes(10);
                $user->save();

                return redirect()->back()->with('the otp has been resend.');
            }

            if ($user->otp_resend_cooldown == NULL) {
                $user->otp_resend_cooldown = Carbon::now()->addMinutes(60);
                $user->save();
            }

            $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', $user->otp_resend_cooldown)->format('Y-m-d g:i A');

            return redirect()->back()->with('resend_otp', 'You have reach maximum sent of OTP. Please wait in ' . $remainingTime);
        } else {
            throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function showResetPassForm()
    {
        $user = User::where('mobile_number', session('reset_password.number'))->whereNotNull('mobile_verified_at')->first();
        if ($user && !auth()->check() && session()->exists('reset_password.change')) {
            return view('client.page.resetPass.NewPassForm');
        }
        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));

    }

    public function checkNewPass(Request $request)
    {
        $user = User::where('mobile_number', session('reset_password'))->whereNotNull('mobile_verified_at')->first();
        if ($user && !auth()->check() && session()->exists('reset_password.change')) {
            $request->validate([
                'password' => ['required','confirmed', 'string', 'min:6', 'max:20', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ]);

            if (Hash::check($request->input('password'), $user->password)) {
                throw ValidationException::withMessages([
                    'password' => 'The new password must be different from the current password.',
                ]);
            }

            $user->password = bcrypt($request->input('password'));
            $user->save();

            session()->remove('reset_password.number');
            session()->remove('reset_password.change');

            return redirect()->route('login')->with('message', 'Password reset successfully!');
        }
        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));

    }
}
