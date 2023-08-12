<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientAuthAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $requiredPage)
    {
       
        if ($requiredPage == true) {
            if (auth()->check()) {
                return $next($request);
            } else {
                return redirect()->route('index');
            }
        } else {
            if (auth()->check()) {
                return redirect()->route('index');
            } else {
                return $next($request);
            }
        }

    }
}
