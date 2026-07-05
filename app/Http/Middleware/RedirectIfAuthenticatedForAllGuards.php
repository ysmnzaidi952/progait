<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedForAllGuards
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('patient')->check()) {
            return redirect()->route('patient.indexpatient');
        }elseif(Auth::guard('doctor')->check()){
            return redirect()->route('doctor.indexdoctor');
        }elseif(Auth::guard('admin')->check()){
            return redirect()->route('staff.indexadmin');
        }elseif(Auth::guard('staff')->check()){
            return redirect()->route('staff.indexstaff');
        }
        return $next($request);
    }
}
