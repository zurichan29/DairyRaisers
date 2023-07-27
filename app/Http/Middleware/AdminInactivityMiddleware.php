<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminInactivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is an admin
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $lastActivityTime = $user->last_activity;

            // If last_activity is null, set it to the current time
            if (!$lastActivityTime) {
                $user->update(['last_activity' => Carbon::now('Asia/Manila')]);
                $lastActivityTime = $user->last_activity;
            } else {
                // Convert last_activity to a Carbon instance for proper comparison
                $lastActivityTime = Carbon::parse($lastActivityTime);
            }

            $inactivityPeriod = 60; // You can adjust this value as per your requirements
            $now = Carbon::now('Asia/Manila');
            // Check if the last activity time is older than the defined inactivity period (in minutes)
            if ($lastActivityTime->diffInMinutes($now) >= $inactivityPeriod) {
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login.administrator')->withErrors(['message' => 'You have been automatically logged out due to inactivity.']);
            }

            // Update the user's last activity time to the current time
            $user->update(['last_activity' => $now]);
        }

        return $next($request);
    }
}
