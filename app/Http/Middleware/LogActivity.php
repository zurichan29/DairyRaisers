<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        $response = $next($request);

        if (Auth::check()) {
            $activityLog = new ActivityLog([
                'admin_id' => Auth::id(),
                'activity_type' => $request->method(),
                'description' => $this->getActivityDescription($request),
                'ip_address' => $request->ip(),
            ]);

            $activityLog->save();
        }

        return $response;
    }
}
