<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    public function showRegister()
    {
        return view('patient.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'patientName' => 'required',
            'patientIC' => 'required|digits:12|unique:patient,patientIC',
            'patientEmail' => 'required|email|unique:patient,patientEmail',
            'patientTel' => 'required',
            'patientPass' => 'required|min:6',
        ]);
        

        Patient::create([
            'patientName' => $request->patientName,
            'patientIC' => $request->patientIC,
            'patientEmail' => $request->patientEmail,
            'patientTel' => $request->patientTel,
            'patientPass' => $request->patientPass,
        ]);
        

        return redirect()->route('patient.login')->with('success', 'Account created!');
    }

    public function showLogin()
    {
        return view('patient.login');
    }

    public function login(Request $request)
    {
        $patient = Patient::where('patientEmail', $request->patientEmail)->first();

        if ($patient && Hash::check($request->patientPass, $patient->patientPass)) {
            Session::put('patient_id', $patient->patientID);
            return redirect()->route('patient.indexpatient');
        }

        return back()->with('error', 'Invalid credentials');
    }

    // public function logout(Request $request)
    // {
    //     Auth::guard('patient')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect()->route('login'); // Redirect to login page
    // }

    public function indexpatient()
    {
        return view('patient.indexpatient');
    }

    // ADMIN: Show patient list
    public function indexAdmin()
    {
        $patients = Patient::all();
        return view('patient.patientlist', compact('patients'));
    }

    // STAFF: Show patient list (same as admin)
    public function indexStaff()
    {
        $patients = Patient::all();
        return view('patient.patientliststaff', compact('patients'));
    }

    // ADMIN: Show patient details
    public function show($patientID)
    {
        $patient = Patient::where('patientId', $patientID)->first();
        return view('patient.patientview', compact('patient'));
    }

    // STAFF: Show patient details (same as admin but different view)
    public function showStaff($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        return view('patient.patientviewstaff', compact('patient'));
    }

    // ADMIN: Show edit form
    public function showEdit($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        return view('patient.patientupdate', compact('patient'));
    }

    // STAFF: Show edit form (same as admin, different view)
    public function showEditStaff($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        return view('patient.patientupdatestaff', compact('patient'));
    }

    // ADMIN: Update patient
    public function update(Request $request, $patientID)
    {
        $request->validate([
            'patientName' => 'required',
            'patientEmail' => 'required|email|unique:patient,patientEmail,' . $patientID . ',patientID',
            'patientTel' => 'required',
            // Add other validations if needed
        ]);

        $patient = Patient::findOrFail($patientID);
        $patient->update([
            'patientName' => $request->patientName,
            'patientEmail' => $request->patientEmail,
            'patientTel' => $request->patientTel,
            'patientIC' => $request->patientIC ?? $patient->patientIC,
            'address' => $request->address ?? $patient->address,
            'dateOfBirth' => $request->dateOfBirth ?? $patient->dateOfBirth,
            'gender' => $request->gender ?? $patient->gender,
            'status' => $request->status ?? $patient->status,
        ]);

        return redirect()->route('admin.patient.patientlist')->with('success', 'Patient updated successfully!');
    }

    // STAFF: Update patient (same logic as admin)
    public function updateStaff(Request $request, $patientID)
    {
        $request->validate([
            'patientName' => 'required',
            'patientEmail' => 'required|email|unique:patient,patientEmail,' . $patientID . ',patientID',
            'patientTel' => 'required',
            // Add other validations if needed
        ]);

        $patient = Patient::findOrFail($patientID);
        $patient->update([
            'patientName' => $request->patientName,
            'patientEmail' => $request->patientEmail,
            'patientTel' => $request->patientTel,
            'patientIC' => $request->patientIC ?? $patient->patientIC,
            'address' => $request->address ?? $patient->address,
            'dateOfBirth' => $request->dateOfBirth ?? $patient->dateOfBirth,
            'gender' => $request->gender ?? $patient->gender,
            'status' => $request->status ?? $patient->status,
        ]);

        return redirect()->route('staff.patient.patientliststaff')->with('success', 'Patient updated successfully!');
    }

    // ADMIN: Delete patient
    public function destroy($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        $patient->delete();

        return redirect()->route('admin.patient.patientlist')->with('success', 'Patient deleted successfully!');
    }

    // STAFF: Delete patient (same as admin)
    public function destroyStaff($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        $patient->delete();

        return redirect()->route('staff.patient.patientliststaff')->with('success', 'Patient deleted successfully!');
    }

    // Doctor: Show patient list
    public function indexDoctor()
    {
        // If you want to filter patients assigned to doctor, add filtering logic here
        $patients = Patient::all(); 
        return view('patient.patientlistdoct', compact('patients'));
    }

    // Doctor: Show patient details
    public function showDoctor($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        return view('patient.patientviewdoct', compact('patient'));
    }

    // Doctor: Show edit form
    public function showEditDoctor($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        return view('patient.patientupdatedoct', compact('patient'));
    }

    // Doctor: Update patient details
    public function updateDoctor(Request $request, $patientID)
    {
        $request->validate([
            'patientName' => 'required',
            'patientEmail' => 'required|email|unique:patient,patientEmail,' . $patientID . ',patientID',
            'patientTel' => 'required',
            // add other validation as necessary
        ]);

        $patient = Patient::findOrFail($patientID);
        $patient->update([
            'patientName' => $request->patientName,
            'patientEmail' => $request->patientEmail,
            'patientTel' => $request->patientTel,
            'patientIC' => $request->patientIC ?? $patient->patientIC,
            'address' => $request->address ?? $patient->address,
            'dateOfBirth' => $request->dateOfBirth ?? $patient->dateOfBirth,
            'gender' => $request->gender ?? $patient->gender,
            'status' => $request->status ?? $patient->status,
            // include any other fields that doctors can update
        ]);

        return redirect()->route('doctor.patientlistdoct')->with('success', 'Patient updated successfully!');
    }

  
    // Show profile view page
    public function viewProfile()
    {
        $patient = auth('patient')->user(); // Get logged-in patient
        return view('profile.patientview', compact('patient'));
    }

    // Show edit profile form
    public function editProfile()
    {
        $patient = auth('patient')->user(); // Get logged-in patient
        return view('profile.patientedit', compact('patient'));
    }

    // Handle update profile submission
    public function updateProfile(Request $request)
    {
        $patient = auth('patient')->user();

        // Validate input
        $request->validate([
            'patientName' => 'required|string|max:255',
            'patientEmail' => 'required|email',
            'patientTel' => 'required|string|max:20',
            'dateOfBirth' => 'nullable|date',
            'maritalStatus' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'race' => 'nullable|string|max:50',
            'gender' => 'nullable|string|max:10',
        ]);

        // Update patient record
        $patient->update([
            'patientName' => $request->patientName,
            'patientEmail' => $request->patientEmail,
            'patientTel' => $request->patientTel,
            'dateOfBirth' => $request->dateOfBirth,
            'maritalStatus' => $request->maritalStatus,
            'address' => $request->address,
            'race' => $request->race,
            'gender' => $request->gender,
        ]);

        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully.');
    }


}
