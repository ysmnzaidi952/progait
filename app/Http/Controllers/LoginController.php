<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Doctor; // Import the Doctor model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('patient.login'); // This view should be in the patient folder
    }

    public function login(LoginRequest $request)
    {
        switch ($request->role) {
            case "patient":
                return redirect()->route('patient.indexpatient');
            case "admin":
                return redirect()->route('staff.indexadmin');
            case "staff":
                return redirect()->route('staff.indexstaff');
            case "doctor":
                return redirect()->route('doctor.indexdoctor');
            default:
                return redirect()->route('login')->with('error', 'Invalid role');
        }

        return $return;
    }

    public function logout(Request $request)
    {
        if (auth()->guard('patient')->check()) {
            Auth::guard('patient')->logout();
        } elseif (auth()->guard('doctor')->check()) {
            Auth::guard('doctor')->logout();
        } elseif (auth()->guard('staff')->check()) {
            Auth::guard('staff')->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login'); // Redirect to login page
    }
}
