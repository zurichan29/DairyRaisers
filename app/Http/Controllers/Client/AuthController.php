<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
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
                'mobile_number' => ['required', 'numeric', 'regex:/^9[0-9]{9}$/'],
                'password' => ['required', 'string'],
            ], [
                'mobile_number.regex' => 'The :attribute must be a valid phone number with 10 characters and starting with 9.',
            ]);
            
            // dd($request->input('password'));
            // dd(Auth::attempt($credentials));
            // if (Auth::attempt($credentials)) {
                
                // }
                if ($this->hasTooManyLoginAttempts($request)) {
                    return;
                }
                $user = User::where('mobile_number', $request->input('mobile_number'))->first();

            if ($user) {
                if ($user->mobile_verified_at == null) {
                    return redirect()->route('verify.mobile.page', ['mobile_number' => $request->input('mobile_number')]);
                } elseif ($user->password == null || $user->first_name == null || $user->last_name == null) {
                    return redirect()->route('register.details.page', ['mobile_number' => $request->input('mobile_number')]);
                }
            }

            // $remember = $request->input('remember', false);

            if (Auth::attempt($credentials)) {
                $this->clearLoginAttempts($request);
                return redirect()->intended('/')->with('message', 'Login Successfully!');
            }

            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                'mobile_number' => 'The provided credentials do not match our records.',
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
