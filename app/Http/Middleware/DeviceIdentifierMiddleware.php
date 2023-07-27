<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GuestUser;
use Symfony\Component\HttpFoundation\Response;

class DeviceIdentifierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('admin')->check()) {
            $deviceIdentifier = $request->cookie('device_identifier');

            if (!$deviceIdentifier) {
                $deviceIdentifier = Str::uuid()->toString();

                // Set the device identifier as a cookie that expires in 30 days
                $response = $next($request);
                $response->cookie('device_identifier', $deviceIdentifier, 30 * 24 * 60);
            } else {
                $response = $next($request);
            }

            $guestUser = GuestUser::where('guest_identifier', $deviceIdentifier)->first();

            if (!$guestUser) {
                $newGuest = new GuestUser();
                $newGuest->guest_identifier = $deviceIdentifier;
                $newGuest->save();
            }
        }

        return $next($request);
    }
}
