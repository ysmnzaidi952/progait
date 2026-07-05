<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    // Show registration form for doctors
    public function showRegister()
    {
        return view('doctor.register');
    }

        public function indexdoctor()
    {
        // Fetch recent patients (customize as needed)
        $recentPatients = \App\Models\Patient::orderBy('created_at', 'desc')->take(100)->get();
        // Add a status property for demo (replace with real status if available)
        foreach ($recentPatients as $patient) {
            $patient->status = 'Active'; // or fetch real status
        }
        return view('doctor.indexdoctor', compact('recentPatients'));
    }

    // Handle doctor registration
    public function register(Request $request)
    {
        $request->validate([
            'docIC' => ['required', 'digits:12', 'unique:doctors,docIC'],  // <-- changed here
            'docName' => 'required',
            'docEmail' => 'required|email|unique:doctors,docEmail',
            'docPass' => 'required|min:6',
            'docTel' => 'required',
        ]);
        

        $latestDoc = Doctor::orderBy('docID', 'desc')->first();
        $nextDocID = 'DOC' . str_pad((substr($latestDoc ? $latestDoc->docID : 'DOC1000', 3) + 1), 4, '0', STR_PAD_LEFT);

        Doctor::create([
            'docID' => $nextDocID,
            'docIC' => $request->docIC,
            'docName' => $request->docName,
            'docEmail' => $request->docEmail,
            'docPass' => $request->docPass,
            'docTel' => $request->docTel,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Doctor registration is pending approval.');
    }

    // Admin approves doctor
    public function approveDoctor($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if ($doctor) {
            $doctor->status = 'approved';
            $doctor->save();

            return redirect()->route('admin.show-approve-doctor-list')->with('success', 'Doctor approved successfully!');
        }

        return back()->with('error', 'Doctor not found');
    }

    // Show pending doctors for admin
    public function showPendingDoctors()
    {
        $pendingDoctors = Doctor::where('status', 'pending')->get();
        return view('admin.approve_doctor', compact('pendingDoctors'));
    }

    // Doctor login
    public function doctorLogin(Request $request)
    {
        // First, clean the input by removing dashes
        $request->merge([
            'docIC' => str_replace('-', '', $request->docIC),
        ]);
    
        // Then validate the cleaned input
        $request->validate([
            'docIC' => 'required|digits:12',
            'docPass' => 'required',
        ]);
    
        // Now fetch doctor by cleaned IC
        $doctor = Doctor::where('docIC', $request->docIC)->first();
    
        if ($doctor && Hash::check($request->docPass, $doctor->docPass)) {
            session(['doctor_id' => $doctor->docID]);
    
            if ($doctor->status === 'approved') {
                return redirect()->route('doctor.indexdoctor');
            }
    
            return back()->with('error', 'Doctor account is not approved yet.');
        }
    
        return back()->with('error', 'Invalid credentials');
    }
    

    // Admin: Show doctor list
    public function showDoctorList()
    {
        $doctors = Doctor::all();
        return view('doctor.doctorlist', compact('doctors'));
    }

    // Admin: Show doctor details
    public function showDoctorView($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorlist')->with('error', 'Doctor not found');
        }

        return view('doctor.doctorview', compact('doctor'));
    }

    // Admin: Show doctor update form
    public function showDoctorEdit($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorlist')->with('error', 'Doctor not found');
        }

        return view('doctor.doctorupdate', compact('doctor'));
    }

    // Admin: Update doctor details
    public function updateDoctor(Request $request, $docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorlist')->with('error', 'Doctor not found');
        }

        $request->validate([
            'docName' => 'required|string|max:255',
            'docEmail' => 'required|email|unique:doctors,docEmail,' . $docID . ',docID',
            'docTel' => 'required|string|max:15',
            'docIC' => 'nullable|string|max:14',
            'status' => 'required|in:pending,approved,active,inactive',
            'dateOfBirth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'race' => 'nullable|string|max:50',
            'maritalStatus' => 'nullable|string|max:20',
            'address' => 'nullable|string',

        ]);

        $doctor->update([
            'docName' => $request->docName,
            'docEmail' => $request->docEmail,
            'docTel' => $request->docTel,
            'docIC' => $request->docIC,
            'status' => $request->status,
            'dateOfBirth' => $request->dateOfBirth,
            'gender' => $request->gender,
            'race' => $request->race,
            'maritalStatus' => $request->maritalStatus,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.doctor.doctorlist')->with('success', 'Doctor details updated successfully!');
    }

    // Admin: Delete doctor
    public function deleteDoctor($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorlist')->with('error', 'Doctor not found');
        }

        $doctor->delete();

        return redirect()->route('admin.doctor.doctorlist')->with('success', 'Doctor deleted successfully!');
    }

    // Staff: Show doctor list (same as admin, full CRUD)
    public function showDoctorListStaff()
    {
        $doctors = Doctor::all();
        return view('doctor.doctorliststaff', compact('doctors'));
    }

    // Staff: Show doctor details
    public function showDoctorViewStaff($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorliststaff')->with('error', 'Doctor not found');
        }

        return view('doctor.doctorviewstaff', compact('doctor'));
    }

    // Staff: Show doctor edit form (same as admin)
    public function showDoctorUpdateStaff($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorliststaff')->with('error', 'Doctor not found');
        }

        return view('doctor.doctorupdatestaff', compact('doctor'));
    }


    // Staff: Update doctor details (same as admin)
    public function updateDoctorStaff(Request $request, $docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorliststaff')->with('error', 'Doctor not found');
        }

        $request->validate([
            'docName' => 'required|string|max:255',
            'docEmail' => 'required|email|unique:doctors,docEmail,' . $docID . ',docID',
            'docTel' => 'required|string|max:15',
            'docIC' => 'nullable|string|max:14',
            'status' => 'required|in:pending,approved,active,inactive',
            'dateOfBirth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'race' => 'nullable|string|max:50',
            'maritalStatus' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $doctor->update([
            'docName' => $request->docName,
            'docEmail' => $request->docEmail,
            'docTel' => $request->docTel,
            'docIC' => $request->docIC,
            'status' => $request->status,
            'dateOfBirth' => $request->dateOfBirth,
            'gender' => $request->gender,
            'race' => $request->race,
            'maritalStatus' => $request->maritalStatus,
            'address' => $request->address,
        ]);

        return redirect()->route('doctor.doctorliststaff')->with('success', 'Doctor details updated successfully!');
    }

    // Staff: Delete doctor
    public function deleteDoctorStaff($docID)
    {
        $doctor = Doctor::where('docID', $docID)->first();

        if (!$doctor) {
            return redirect()->route('doctor.doctorliststaff')->with('error', 'Doctor not found');
        }

        $doctor->delete();

        return redirect()->route('doctor.doctorliststaff')->with('success', 'Doctor deleted successfully!');
    }
}
