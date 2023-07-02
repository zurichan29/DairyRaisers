<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLoginAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 5, $decayMinutes = 60): Response
    {
        $key = $this->resolvedRequestKey($request);
        $attempts = Cache::get($key, 0);

        if($attempts >= $maxAttempts) {
            return response()->json(['message' => 'Too many login attempts. Please try again later.'], 429);
        }

        $response = $next($request);

        if ($response->getStatusCode() !== 200) 
        {
            Cache::add($key, $attempts + 1, $decayMinutes);
        }

        return $response;
    }

    protected function resolvedRequestKey($request)
    {
        return sha1($request->ip() . '|' . $request->input('mobile_number'));
    }
}
