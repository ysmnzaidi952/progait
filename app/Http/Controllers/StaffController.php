<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    public function showRegister()
    {
        return view('staff.registerstaff');
    }

    public function register(Request $request)
    {
        $request->validate([
            'staffName' => 'required',
            'staffIC' => 'required|digits:12|unique:staff,staffIC',
            'staffEmail' => 'required|email|unique:staff,staffEmail',
            'staffPass' => 'required|min:6',
            'staffTel' => 'required',
        ]);

        // Auto-generate new staff ID
        $lastStaff = Staff::orderBy('staffID', 'desc')->first();
        $newNumber = $lastStaff ? (int)substr($lastStaff->staffID, 2) + 1 : 1001;
        $newStaffID = 'PG' . $newNumber;

        // Create new staff
        Staff::create([
            'staffID' => $newStaffID,
            'staffName' => $request->staffName,
            'staffIC' => $request->staffIC,
            'staffEmail' => $request->staffEmail,
            'staffPass' => $request->staffPass,
            'staffTel' => $request->staffTel,
            'staffRole' => 'staff', // Auto-assign role
            'status' => 'pending',
        ]);

        return back()->with('success', 'Staff registration is pending approval.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'loginID' => 'required',
            'password' => 'required',
        ]);

        $staff = Staff::where('staffID', $request->loginID)->first();

        if ($staff && Hash::check($request->password, $staff->staffPass)) {
            // Check if staff status is approved before allowing login
            if ($staff->status !== 'approved') {
                return back()->with('error', 'Your account is not approved yet.');
            }

            Session::put('staff_id', $staff->staffID);

            return match ($staff->staffRole) {
                'admin' => redirect()->route('admin.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                default => back()->with('error', 'Role not recognized'),
            };
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function logout()
    {
        Session::forget('staff_id');
        return redirect()->route('login');
    }

    public function showPendingStaff()
    {
        $pendingStaff = Staff::where('status', 'pending')->get(); // Get all pending staff
        return view('admin.approve_staff', compact('pendingStaff')); // Pass the staff to the view
    }

    public function approveStaff($staffID)
    {
        $staff = Staff::where('staffID', $staffID)->first();

        if ($staff) {
            $staff->status = 'approved'; // Set status to 'approved'
            $staff->save(); // Save the updated status

            return redirect()->route('admin.show-approve-list')->with('success', 'Staff approved successfully!');
        }

        return back()->with('error', 'Staff not found');
    }

    public function showAllStaff()
    {
        $staff = Staff::all(); // Get all staff (approved and pending)
        return view('staff.stafflist', compact('staff'));
    }

    public function showStaffView($staffID)
    {
        $staff = Staff::where('staffID', $staffID)->first(); // Get staff by ID
        if ($staff) {
            return view('staff.staffview', compact('staff'));
        }
        return back()->with('error', 'Staff not found');
    }

    public function showStaffEdit($staffID)
    {
        $staff = Staff::where('staffID', $staffID)->first(); // Get staff by ID
        if ($staff) {
            return view('staff.staffupdate', compact('staff'));
        }
        return back()->with('error', 'Staff not found');
    }

    public function updateStaff(Request $request, $staffID)
    {
        $staff = Staff::where('staffID', $staffID)->first();

        if ($staff != null) {
            $request->validate([
                'staffName' => 'required',
                'staffEmail' => 'required|email',
                'staffRole' => 'required|in:admin,staff',
                'staffTel' => 'required',
            ]);

            $staff->update([
                'staffName' => $request->staffName,
                'staffEmail' => $request->staffEmail,
                'staffRole' => $request->staffRole,
                'staffTel' => $request->staffTel,
            ]);

            return redirect()->route('admin.stafflist')->with('success', 'Staff updated successfully');
        }

        return back()->with('error', 'Staff not found');
    }

    public function deleteStaff($staffID)
    {
        $staff = Staff::where('staffID', $staffID)->first();
        if ($staff) {
            $staff->delete();
            return redirect()->route('admin.stafflist')->with('success', 'Staff deleted successfully');
        }
        return back()->with('error', 'Staff not found');
    }


    // For edit page (view profile)
    public function profile()
    {

        $staff = auth()->user();

        return view('profile.adminedit', compact('staff'));

    }

    // For updating
    public function updateProfile(Request $request)
    {
        $staff = auth()->user();


        $validated = $request->validate([
            'staffName' => 'required|string|max:255',
            'staffIC' => 'required|digits_between:12,14',
            'staffEmail' => 'required|email',
            'staffTel' => 'required',
            'dateOfBirth' => 'required|date',
            'gender' => 'required',
            'maritalStatus' => 'nullable',
            'race' => 'nullable',
            'address' => 'nullable',
        ]);

        $staff->update($validated);

        return redirect()->route('admin.profile.view')->with('success', 'Profile updated successfully.');
    }

    // For viewing
    public function adminViewProfile()
    {
        $staff = auth()->user();


        $totalPatients = \App\Models\Patient::count();
        $totalAppointments = \App\Models\Appointment::count();
        $totalStaff = \App\Models\Staff::count();
        $totalAssessments = \App\Models\Assessment::count();

        return view('profile.adminview', compact(
            'staff',
            'totalPatients',
            'totalAppointments',
            'totalStaff',
            'totalAssessments'
        ));
    }

    public function viewStaffProfile()
    {
        $staff = auth('staff')->user();
        return view('profile.staffview', compact('staff'));
    }

    public function editStaffProfile()
    {
        $staff = auth('staff')->user();
        return view('profile.staffedit', compact('staff'));
    }

    public function updateStaffProfile(Request $request)
    {
        $staff = auth('staff')->user();

        $validated = $request->validate([
            'staffName' => 'required|string|max:255',
            'staffIC' => 'required|digits_between:12,14',
            'staffEmail' => 'required|email',
            'staffTel' => 'required',
            'dateOfBirth' => 'required|date',
            'gender' => 'required',
            'maritalStatus' => 'nullable',
            'race' => 'nullable',
            'address' => 'nullable',

        ]);

        $staff->update($validated);

        return redirect()->route('staff.profile.view')->with('success', 'Profile updated successfully.');
    }






}
