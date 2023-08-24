<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class CheckStaffAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$requiredAccess)
    {
        session()->forget('no_access');
        // Check if the staff is authenticated
        if (auth()->guard('admin')->check()) {
            // Get the authenticated staff
            $staff = auth()->guard('admin')->user();
            if($staff->is_admin) {
                return $next($request);
            }
            // Convert the staff's access to an array if it's not already an array
            $staffAccess = is_array($staff->access) ? $staff->access : json_decode($staff->access, true);
            // Check if the staff has the required access for the current route
            foreach ($requiredAccess as $access) {
               
                if (!in_array($access, $staffAccess)) {
                    // Staff does not have the required access, store the error message in the session
                    $errorMessage = 'You do not have permission to access this page.';
                    session()->flash('no_access', $errorMessage);
                    break;
                }
            }

            // Staff has the required access, continue to the requested page
            return $next($request);
        }

        // Staff is not authenticated, redirect to login page
        return redirect()->route('login.administrator');
    }
}
