<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    public function map()
    {
        // Existing code...

        $this->configureRateLimiting();

        Route::middleware(['web', 'throttle:5,60'])->group(function () {
            Route::post('/profile/email/resend_code', function (Request $request) {
                // Your email verification logic
                $user = Auth::user();

                if ($user) {
                    $new_token = Str::random(40);

                    // Validate the uniqueness of the token
                    $validator = Validator::make($request->all(), [
                        'verification_token' => [
                            'nullable',
                            'string',
                            'max:255',
                            Rule::unique('users')->where(function ($query) use ($new_token) {
                                return $query->where('verification_token', $new_token);
                            }),
                        ],
                    ]);

                    // If the token is not unique, generate a new one
                    if ($validator->fails()) {
                        $new_token = Str::random(40);
                    }

                    $user->email_verify_token = $new_token;
                    $user->email_code_count += 1;
                    
                    if($user->email_code_count > 3) {
                        return redirect()->back()->with('error', 'Email limit');
                    } else {
                        $user->save();
    
                        Mail::to($user->email)->send(new VerifyEmail($user));
    
                        $user = Auth::user();

                    }
                    
                    
                    // $cacheKey = 'email_verification_attempts:' . $user->id;
                    // $attempts = Cache::get($cacheKey, 0);
                    // $attempts++;
                    // Cache::put($cacheKey, $attempts, Carbon::now()->addHour());
                    // // Check if the limit is exceeded
                    // if ($attempts > 5) {
                    //     // Handle the case when the limit is exceeded
                    // }
                } else {
                }
            })->name('verification.verify');
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('email_verification', function ($request) {
            return Limit::perHour(5)->response(function () {
                abort(429, 'Too Many Requests');
            });
        });
    }
}
