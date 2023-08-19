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
use App\Mail\resetPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use App\Mail\AdminResetPasswordMail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;

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

        if (Auth::attempt($credentials)) {
            $user->email_code_count = 0;
            $user->email_code_cooldown = null;
            $user->email_verify_token = null;
            $user->reset_password = false;
            $user->reset_password_token = null;
            $user->reset_password_count = 0;
            $user->reset_password_cooldown = null;
            $user->save();
            session()->forget('guest_address');
            session()->forget('order_data');
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

            return redirect()->route('admin.dashboard')->with('message', [
                'type' => 'success',
                'title' => 'Welcome back ' . $admin->name,
                'body' => 'Admin user has successfully logged in to the system.',
            ]);
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']); // Redirect back to the login page with an error message
        }
    }








    public function showLinkRequestForm()
    {
        return view('client.auth.admin_reset_password');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('client.auth.admin_new_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function resetAdminPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ], [
            'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
        ]);

        $response = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($admin, $password) {
                $admin->password = bcrypt($password);
                // $admin->setRememberToken(Str::random(60));
                $admin->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect(route('login.administrator'))->with('status', 'Password has been reset!')
            : back()->withErrors(['email' => [__($response)]]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            $token = $this->generatePasswordResetToken($admin);
            DB::table('password_resets_admin')->updateOrInsert(
                ['email' => $admin->email],
                ['email' => $admin->email, 'token' => Hash::make($token), 'created_at' => now()]
            );
            Mail::to($admin->email)->send(new AdminResetPasswordMail($token, $admin));

            return back()->with('status', 'We have emailed your password reset link!');
        } else {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }
    }


    protected function generatePasswordResetToken($user)
    {
        return app('auth.password.broker')->createToken($user);
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
        if (($user->reset_password_count >= 3 && Carbon::now() >= $user->reset_password_cooldown) || Carbon::now() >= $user->reset_password_cooldown) {
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
        $user->reset_password_cooldown = Carbon::now()->addHour();
        $user->reset_password_token = Str::random(60);
        $user->save();

        Mail::to($user->email)->send(new resetPassword($user));

        return redirect()->route('reset_password')->with('message', [
            'type' => 'success',
            'title' => 'Password Reset',
            'body' => 'A password reset link has been sent to your email address.',
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

            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ], [
                'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user->password = Hash::make($request->input('password'));
            $user->reset_password = false;
            $user->reset_password_token = null;
            $user->reset_password_count = 0;
            $user->reset_password_cooldown = null;
            $user->save();

            session()->flash('message', [
                'type' => 'success',
                'title' => 'Password Reset Successful',
                'body' => "Your account password has been successfully reset. If you didn't initiate this change, please contact our support team immediately.",
                'period' => false,
            ]);
            return response()->json([
                'success' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Password Reset Successful',
                    'body' => 'Your account password has been successfully reset. If you did not initiate this change, please contact our support team immediately.',
                    'period' => false,
                ],
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





    public function logout()
    {
        auth()->logout();
        return redirect()->route('index')->with('message', [
            'type' => 'info',
            'title' => 'You have been logged out!',
            'body' => null,
            'period' => false,
        ]);;
    }

    public function logout_admin()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('login.administrator')->with('message', [
            'type' => 'info',
            'title' => 'You have been logged out!',
            'body' => null,
            'period' => false,
        ]);
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
