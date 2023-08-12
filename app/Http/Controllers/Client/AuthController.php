<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Rules\AuthRule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{

    public function show()
    {
        return view('client.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', function ($attribute, $value, $fail) {
                $user = User::where('email', $value)->first();

                if ($user && $user->email_verified_at === null) {
                    $fail('The email address is not yet verified.');
                }
            }],
            'password' => ['required'],
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            return;
        }

        $user = User::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user->email_code_count = 0;
            $user->email_code_cooldown = null;
            $user->email_verify_token = null;
            $user->reset_password = false;
            $user->reset_password_token = null;
            $user->reset_password_count = 0;
            $user->reset_password_cooldown = null;
            $user->save();
            $this->clearLoginAttempts($request);
            return redirect()->route('index')->with('message', [
                'type' => 'success',
                'title' => 'Welcome Back  ' . $user->first_name . '!',
                'body' => 'You have successfully logged in.',
                'period' => false,
            ]);
        } else {
            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                'not_valid' => 'The provided credentials do not match our records.',
            ])->status(422);
        }
    }

    public function show_admin()
    {
        if (auth()->guard('admin')->check()) {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
        return view('client.auth.admin');
    }

    public function admin_auth(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            // Admin logged in successfully

            // Update the last_activity field to the current time
            $admin = Auth::guard('admin')->user();

            return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
        } else {
            // Failed to log in admin
            return back()->withErrors(['email' => 'Invalid credentials']); // Redirect back to the login page with an error message
        }
    }

    public function reset_password()
    {
        return view('client.auth.reset_password');
    }

    public function verify_rp(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email', function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)
                        ->whereNotNull('email_verified_at')
                        ->first();

                    if (!$user) {
                        $fail("The provided email is not valid or is not yet verified.");
                    }
                },
            ],
        ]);

        $user = User::where('email', $request->email)->first();
        $user->reset_password = true;
        if ($user->reset_password_count >= 3 && Carbon::now() >= $user->reset_password_cooldown) {
            $user->reset_password_count = 0;
            $user->reset_password_cooldown =  null;
            $user->save();
        }

        if ($user->reset_password_count >= 3 && Carbon::now()->lt($user->reset_password_cooldown)) {
            throw ValidationException::withMessages([
                'email' => 'You have used up all of your attempts to resend email verification. Please wait a moment and try again.',
            ])->status(422);
        }

        $user->reset_password_count = $user->reset_password_count + 1;
        if ($user->reset_password_count >= 3) {
            $user->reset_password_cooldown = Carbon::now()->addHour();
        }
        $user->reset_password_token = Str::random(60);
        $user->save();

        return redirect()->route('reset_password')->with('message', [
            'type' => 'success',
            'title' => 'Email sent',
            'body' => 'Verification token has been sent to your email. Please check your inbox.',
            'period' => false,
        ]);
    }

    public function new_password(Request $request, $token, $email)
    {
        $user = User::where('email', $email)
            ->whereNotNull('email_verified_at')
            ->where('reset_password', true)
            ->where('reset_password_token', $token)->first();

        if ($user) {
            return view('client.auth.new_password', ['token' => $token, 'email' => $email]);
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function verify_np(Request $request, $token, $email)
    {
        $user = User::where('email', $email)
            ->whereNotNull('email_verified_at')
            ->where('reset_password', true)
            ->where('reset_password_token', $token)->first();
        if ($user) {
            $request->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ], [
                'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
            ]);

            $user->password = Hash::make($request->input('password'));
            $user->reset_password = false;
            $user->reset_password_token = null;
            $user->reset_password_count = 0;
            $user->reset_password_cooldown = null;
            $user->save();
            return redirect()->route('index')->with('message', [
                'type' => 'success',
                'title' => 'Password Reset',
                'body' => 'Your password has been successfully reset.',
                'period' => false,
            ]);
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }









    public function resetPasswordForm()
    {
        return view('client.auth.reset_password');
    }

    public function checkRPForm(Request $request)
    {
        $number = $request->input('number');
        $country_code = '+63'; // Country code to be removed
        $number = str_replace($country_code, '', $number);
        $user = User::where('mobile_number', $number)->first();

        if ($user) {
            if ($user->mobile_verified_at != NULL) {
                return response()->json([
                    'status' => 'verified'
                ]);
            } else {
                return response()->json([
                    'status' => 'userError',
                    'user' => $user

                ]);
            }
        } else {
            return response()->json([
                'status' => 'userError'
            ]);
        }
    }

    public function verifyRPForm(Request $request)
    {


        $user = User::where('mobile_number', $request->input('number'))->first();

        if ($user) {
            session(['password_reset.mobile_number' => $request->input('number')]);

            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }

    public function newPasswordForm(Request $request, $number)
    {
        $user = User::where('mobile_number', $number)->first();

        if ($user && session()->exists('password_reset.mobile_number')) {
            return view('client.auth.new_password', ['number' => $number]);
        } else {
            return redirect()->route('index');
        }
    }

    public function verifyNewPass(Request $request, $number)
    {
        $user = User::where('mobile_number', $number)->first();

        if ($user && session()->exists('password_reset.mobile_number')) {
            $request->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ], [
                'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
            ]);

            $user->password = Hash::make($request->input('password'));
            $user->save();

            session()->forget('password_reset.mobile_number');

            return redirect()->intended('/login')->with('success', 'Password has been successfully reset. Please enter your credentials to login.');
        } else {
            return redirect()->route('index');
        }
    }



    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

    public function logout_admin()
    {
        if (auth()->guard('admin')->check()) {
            auth()->guard('admin')->logout();
            return redirect()->route('login.administrator')->with('message', 'You have been logged out!');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }


    /** SUB FUNCTION */

    protected function hasTooManyLoginAttempts(Request $request)
    {
        $key = sha1($request->ip() . '|' . $request->input('email'));

        $rateLimiter = app(RateLimiter::class);
        // dd($key);

        if ($rateLimiter->tooManyAttempts($key, 5)) {
            $remainingSeconds = $rateLimiter->availableIn($key);
            $remainingTime = gmdate('i:s', $remainingSeconds);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$remainingTime}",
            ])->status(429);
        }
        return false;
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $key = sha1($request->ip() . '|' . $request->input('email'));

        $rateLimiter = app(RateLimiter::class);
        $rateLimiter->hit($key, Carbon::now()->addMinutes(60)->diffInSeconds());
    }

    protected function clearLoginAttempts(Request $request)
    {
        $key = sha1($request->ip() . '|' . $request->input('email'));

        $rateLimiter = app(RateLimiter::class);
        $rateLimiter->clear($key);
    }
}
