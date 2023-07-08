<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Rules\AuthRule;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function show()
    {
        return view('client.page.auth.login');
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
                $admin = Admin::where('email', $credentials['email'])->first();
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

            if ($user && $user->role == 'user') {
                if ($user->password == null || $user->first_name == null || $user->last_name == null) {
                    return redirect()->route('register.details.page', ['mobile_number' => $user->mobile_number]);
                }
            }
            
            // Attempt authentication with modified credentials and remember option
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $this->clearLoginAttempts($request);
                if (auth()->user()->isAdmin()) {
                    return redirect()->intended('/admin/dashboard')->with('message', 'Welcome Back Admin!');
                } else {
                    return redirect()->intended('/')->with('message', 'Login Successfully!');
                }
            }

            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                'user_field' => 'The provided credentials do not match our records.',
            ])->status(422);
        }
        
        throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();

            return redirect('/')->with('message', 'You have been logged out!');
        } else {
            throw new HttpResponseException(response()->view('client.404_page', [], Response::HTTP_NOT_FOUND));
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
