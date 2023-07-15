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

class AuthController extends Controller
{
    public function show()
    {
        return view('client.auth.login');
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
        if (auth()->guard('admin')->check()) {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            // Admin logged in successfully
            return redirect()->intended('/admin/dashboard'); // Redirect to the admin dashboard or any desired page
        } else {
            // Failed to log in admin
            return back()->withErrors(['email' => 'Invalid credentials']); // Redirect back to the login page with an error message
        }
    }

    public function resetPasswordForm()
    {
        if (!auth()->check()) {
            return view('client.auth.reset_password');
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function checkRPForm(Request $request)
    {
        if (!auth()->check()) {
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
    }

    public function verifyRPForm(Request $request)
    {
        if (!auth()->check()) {

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
    }

    public function newPasswordForm(Request $request, $number)
    {
        if (!auth()->check()) {
            $user = User::where('mobile_number', $number)->first();

            if ($user && session()->exists('password_reset.mobile_number')) {
                return view('client.auth.new_password', ['number' => $number]);
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }

        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function verifyNewPass(Request $request, $number)
    {
        if (!auth()->check()) {
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
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }

        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function authenticate(Request $request)
    {
        if (!auth()->check()) {
            $credentials = $request->validate([
                'user_field' => ['required'],
                'password' => ['required', 'string'],
            ]);

            if ($this->hasTooManyLoginAttempts($request)) {
                return;
            }

            // Check if 'user_field' is either email or mobile_number
            $userField = $credentials['user_field'];
            if (filter_var($userField, FILTER_VALIDATE_EMAIL)) {
                // Use email for authentication
                $credentials['email'] = $userField;
                $user = User::where('email', $credentials['email'])->first();
                unset($credentials['user_field']);
            } else if (preg_match('/^9[0-9]{9}$/', $userField)) {
                // Use mobile_number for authentication
                $credentials['mobile_number'] = $userField;
                $user = User::where('mobile_number', $credentials['mobile_number'])->first();
                unset($credentials['user_field']);
            } else {
                return redirect()->back()->withErrors(['user_field' => 'Invalid input format.'])->withInput();
            }

            if ($user->password == null || $user->first_name == null || $user->last_name == null) {
                return redirect()->route('register.details.page', ['mobile_number' => $user->mobile_number]);
            }

            // Attempt authentication with modified credentials and remember option
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $this->clearLoginAttempts($request);
                return redirect()->intended('/')->with('message', 'Login Successfully!');
            }

            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                'user_field' => 'The provided credentials do not match our records.',
            ])->status(422);
        }

        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();

            return redirect('/')->with('message', 'You have been logged out!');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function logout_admin()
    {
        if (auth()->guard('admin')->check()) {
            auth()->guard('admin')->logout();
            return redirect('/')->with('message', 'You have been logged out!');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }


    /** SUB FUNCTION */

    protected function hasTooManyLoginAttempts(Request $request)
    {
        $key = sha1($request->ip() . '|' . $request->input('mobile_number'));

        $rateLimiter = app(RateLimiter::class);

        if ($rateLimiter->tooManyAttempts($key, 5)) {
            $remainingSeconds = $rateLimiter->availableIn($key);
            $remainingTime = gmdate('i:s', $remainingSeconds);
            throw ValidationException::withMessages([
                'mobile_number' => "Too many login attempts. Please try again in {$remainingTime}",
            ])->status(429);
        }
        return false;
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $key = sha1($request->ip() . '|' . $request->input('mobile_number'));

        $rateLimiter = app(RateLimiter::class);
        $rateLimiter->hit($key, Carbon::now()->addMinutes(60)->diffInSeconds());
    }

    protected function clearLoginAttempts(Request $request)
    {
        $key = sha1($request->ip() . '|' . $request->input('mobile_number'));

        $rateLimiter = app(RateLimiter::class);
        $rateLimiter->clear($key);
    }
}
