<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Doctor;

class MedicalRecordController extends Controller
{
    /**
     * Admin: Show create form
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all(); // load doctors
        return view('medical.admincreate', compact('patients', 'doctors'));
    }



    /**
     * Shared store logic (Admin + Doctor)
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patient,patientID',
            'status' => 'required',
            'amputation_level' => 'required',
            'k_level' => 'required',
            'health_condition' => 'required',
        ]);

        $assignedDoctor = $request->assigned_doctor ?? (auth()->check() ? auth()->user()->name : null);

        MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'status' => $request->status,
            'assigned_doctor' => $assignedDoctor,
            'amputation_level' => $request->amputation_level,
            'amputation_date' => $request->amputation_date,
            'weight_kg' => $request->weight_kg,
            'height_cm' => $request->height_cm,
            'bmi' => $request->bmi,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'blood_sugar_level' => $request->blood_sugar_level,
            'k_level' => $request->k_level,
            'health_condition' => $request->health_condition,
            'blart_score' => $request->blart_score,
            'mobility_aid_used' => $request->mobility_aid_used,
            'rehabilitation_status' => $request->rehabilitation_status,
            'treatment_notes' => $request->treatment_notes,
        ]);

        // Redirect based on user role
        if (auth()->user()->role === 'doctor') {
            return redirect()->route('doctor.patientlistdoct')->with('success', 'Medical record created.');
        } else {
            return redirect()->route('admin.medical.list')->with('success', 'Medical record created successfully.');
        }
    }

    public function adminList()
    {
        $medicalRecords = MedicalRecord::with('patient')->orderBy('updated_at', 'desc')->get();

        return view('medical.adminlist', compact('medicalRecords'));
    }


    /**
     * Admin: List all medical records
     */
    public function index()
    {
        $medicalRecords = MedicalRecord::with('patient')->latest()->paginate(10);

        // Optional dashboard stats
        $totalRecords = $medicalRecords->count();
        $inTreatment = $medicalRecords->where('status', 'In Treatment')->count();
        $recovered = $medicalRecords->where('status', 'Recovered')->count();
        $followUp = $medicalRecords->where('status', 'Follow-up')->count();
        // yang ni kan ?
        return view('medical.adminlist', compact(
            'medicalRecords',
            'totalRecords',
            'inTreatment',
            'recovered',
            'followUp'
        ));

        //yang tu dekat atas list
    }

    /**
     * Admin: View a medical record.
     */
    public function view($medID)
    {
        // Find the medical record by ID, along with patient data.
        $record = MedicalRecord::with('patient')->findOrFail($medID);

        // Return the 'adminview' view with the record data.
        return view('medical.adminview', compact('record'));
    }

    public function edit($medID)
    {
        $record = MedicalRecord::with('patient')->findOrFail($medID);
        $doctors = \App\Models\Doctor::all();
        return view('medical.adminupdate', compact('record', 'doctors'));
    }



    /**
     * Admin: Update a medical record.
     */
    public function update(Request $request, $medID)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'assigned_doctor' => 'required|string',
            'amputation_level' => 'required|string',
            'amputation_date' => 'nullable|date',
            'weight_kg' => 'nullable|numeric|min:0',
            'height_cm' => 'nullable|numeric|min:0',
            'bmi' => 'nullable|numeric|min:0',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|numeric|min:0',
            'blood_sugar_level' => 'nullable|numeric|min:0',
            'k_level' => 'required|string',
            'health_condition' => 'required|string',
            'blart_score' => 'nullable|numeric|min:0|max:30',
            'mobility_aid_used' => 'nullable|string',
            'rehabilitation_status' => 'nullable|string',
            'treatment_notes' => 'nullable|string',
        ]);

        // Find the medical record by ID
        $record = MedicalRecord::findOrFail($medID);

        // Update the record
        $record->update([
            'status' => $request->status,
            'assigned_doctor' => $request->assigned_doctor,
            'amputation_level' => $request->amputation_level,
            'amputation_date' => $request->amputation_date,
            'weight_kg' => $request->weight_kg,
            'height_cm' => $request->height_cm,
            'bmi' => $request->bmi,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'blood_sugar_level' => $request->blood_sugar_level,
            'k_level' => $request->k_level,
            'health_condition' => $request->health_condition,
            'blart_score' => $request->blart_score,
            'mobility_aid_used' => $request->mobility_aid_used,
            'rehabilitation_status' => $request->rehabilitation_status,
            'treatment_notes' => $request->treatment_notes,
        ]);

        return redirect()->route('admin.medical.view', $record->medID)->with('success', 'Medical record updated successfully.');
    }


    /**
     * Admin: Delete a record
     */
    public function destroy($medID)
    {
        $record = MedicalRecord::findOrFail($medID);
        $record->delete();

        return redirect()->route('admin.medical.list')->with('success', 'Medical record deleted.');
    }

    public function doctorIndex()
    {
        $doctorName = auth()->user()->docName;

        $medicalRecords = MedicalRecord::with('patient')
            ->where('assigned_doctor', 'LIKE', '%'.$doctorName.'%')
            ->latest()
            ->get();

        // Summary stats
        $totalRecords = $medicalRecords->count();
        $inTreatment = $medicalRecords->where('status', 'In Treatment')->count();
        $recovered = $medicalRecords->where('status', 'Recovered')->count();
        $followUp = $medicalRecords->where('status', 'Follow-up')->count();
        $k3Plus = $medicalRecords->whereIn('k_level', ['K3', 'K4'])->count();

        return view('medical.doctorlist', compact(
            'medicalRecords',
            'totalRecords',
            'inTreatment',
            'recovered',
            'followUp',
            'k3Plus'
        ));
    }

    public function destroyDoctor($medID)
    {
        $record = MedicalRecord::findOrFail($medID);

        // Optional: Check if the doctor owns this record
        if ($record->assigned_doctor !== auth()->user()->name) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $record->delete();

        return redirect()->route('doctor.medical.list')->with('success', 'Medical record deleted.');
    }

    /**
 * Doctor: Show create form
 */
public function doctorCreate()
{
    $patients = Patient::all(); // You can later filter by doctor if needed
    $doctors = Doctor::all(); // Add this line to load doctors
    return view('medical.doctorcreate', compact('patients', 'doctors')); // Include doctors in compact
}
}
