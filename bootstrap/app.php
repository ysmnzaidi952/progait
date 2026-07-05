<?php

use App\Http\Middleware\RedirectIfAuthenticatedForAllGuards;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectUsersTo(function (Request $request) {
            if(Auth::guard("patient")->check()){
                return route('patient.indexpatient');
            } elseif(Auth::guard("doctor")->check()){
                return route ('doctor.indexdoctor');
            } elseif(Auth::guard("admin")->check()){
                return route ('staff.indexadmin');
            } elseif(Auth::guard("staff")->check()){
                return route ('staff.indexstaff');
            } 

            return route('login');
        });

        $middleware->alias([
            'guest.all' => RedirectIfAuthenticatedForAllGuards::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
