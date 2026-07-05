<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Doctor;

class AssessmentController extends Controller
{
    public function create()
    {
        $patients = Patient::all();
        $staff = Staff::where('status', 'approved')->get();
        $doctors = Doctor::where('status', 'approved')->get();
        $totalPatients = Patient::count();
        $totalStaff = $staff->count();
        $totalDoctors = $doctors->count();

        return view('assessmentform.create', compact('patients', 'staff', 'doctors', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patient,patientID',
            'attendedBy' => 'required|string',
            'prescribedBy' => 'required|string',
        ]);

        $dialysisDaysString = is_array($request->dialysisDay) ? implode(',', $request->dialysisDay) : null;

        Assessment::create([
            'patientID' => $request->patient_id,
            'hospital' => $request->hospital,
            'footSize' => $request->footSize,
            'linerSize' => $request->linerSize,
            'prosthesisNo' => $request->prosthesisNo,
            'reasonAmputation' => $request->reasonAmputation,
            'patientAssessment' => $request->patientAssessment,
            'dialysisDay' => $dialysisDaysString,
            'componentSuggestions' => $request->componentSuggestions,
            'attendedBy' => $request->attendedBy,
            'prescribedBy' => $request->prescribedBy,
            'receiveDate' => $request->receiveDate,
        ]);

        return redirect()->route('admin.assessment.list')->with('success', 'Assessment submitted successfully!');
    }

    public function index()
    {
        $assessments = Assessment::with('patient')->latest()->paginate(10);
        $totalPatients = Patient::count();
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();

        return view('assessmentform.list', compact('assessments', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function show($formID)
    {
        $assessment = Assessment::with('patient')->findOrFail($formID);
        $totalPatients = Patient::count();
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();

        return view('assessmentform.view', compact('assessment', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function edit($formID)
    {
        $assessment = Assessment::findOrFail($formID);
        $patients = Patient::all();
        $staff = Staff::where('status', 'approved')->get();
        $doctors = Doctor::where('status', 'approved')->get();
        $totalPatients = Patient::count();
        $totalStaff = $staff->count();
        $totalDoctors = $doctors->count();

        return view('assessmentform.update', compact('assessment', 'patients', 'staff', 'doctors', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function update(Request $request, $formID)
    {
        $assessment = Assessment::findOrFail($formID);

        $request->validate([
            'patient_id' => 'required|exists:patient,patientID',
            'attendedBy' => 'required|string',
            'prescribedBy' => 'required|string',
        ]);

        $dialysisDaysString = is_array($request->dialysisDay) ? implode(',', $request->dialysisDay) : null;

        $assessment->update([
            'patient_id' => $request->patient_id,
            'hospital' => $request->hospital,
            'footSize' => $request->footSize,
            'linerSize' => $request->linerSize,
            'prosthesisNo' => $request->prosthesisNo,
            'reasonAmputation' => $request->reasonAmputation,
            'patientAssessment' => $request->patientAssessment,
            'dialysisDay' => $dialysisDaysString,
            'componentSuggestions' => $request->componentSuggestions,
            'attendedBy' => $request->attendedBy,
            'prescribedBy' => $request->prescribedBy,
            'receiveDate' => $request->receiveDate,
        ]);

        return redirect()->route('admin.assessment.list')->with('success', 'Assessment updated successfully!');
    }

    public function destroy($formID)
    {
        Assessment::findOrFail($formID)->delete();
        return redirect()->route('admin.assessment.list')->with('success', 'Assessment deleted successfully!');
    }

    public function staffIndex()
    {
        $assessments = Assessment::with('patient')->latest()->paginate(10);
        $totalPatients = Patient::count();
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();

        return view('assessmentform.liststaff', compact('assessments', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function staffCreate()
    {
        $patients = Patient::all();
        $staff = Staff::where('status', 'approved')->get();
        $doctors = Doctor::where('status', 'approved')->get();
        $totalPatients = Patient::count();
        $totalStaff = $staff->count();
        $totalDoctors = $doctors->count();

        return view('assessmentform.createstaff', compact('patients', 'staff', 'doctors', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function staffStore(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patient,patientID',
            'attendedBy' => 'required|string',
            'prescribedBy' => 'required|string',
        ]);

        $dialysisDaysString = is_array($request->dialysisDay) ? implode(',', $request->dialysisDay) : null;

        Assessment::create([
            'patientID' => $request->patient_id,
            'hospital' => $request->hospital,
            'footSize' => $request->footSize,
            'linerSize' => $request->linerSize,
            'prosthesisNo' => $request->prosthesisNo,
            'reasonAmputation' => $request->reasonAmputation,
            'patientAssessment' => $request->patientAssessment,
            'dialysisDay' => $dialysisDaysString,
            'componentSuggestions' => $request->componentSuggestions,
            'attendedBy' => $request->attendedBy,
            'prescribedBy' => $request->prescribedBy,
            'receiveDate' => $request->receiveDate,
        ]);

        return redirect()->route('staff.assessment.list')->with('success', 'Assessment submitted successfully!');
    }

    public function staffShow($formID)
    {
        $assessment = Assessment::with('patient')->findOrFail($formID);
        $totalPatients = Patient::count();
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();

        return view('assessmentform.viewstaff', compact('assessment', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function staffEdit($formID)
    {
        $assessment = Assessment::findOrFail($formID);
        $patients = Patient::all();
        $staff = Staff::where('status', 'approved')->get();
        $doctors = Doctor::where('status', 'approved')->get();
        $totalPatients = Patient::count();
        $totalStaff = $staff->count();
        $totalDoctors = $doctors->count();

        return view('assessmentform.updatestaff', compact('assessment', 'patients', 'staff', 'doctors', 'totalPatients', 'totalStaff', 'totalDoctors'));
    }

    public function staffUpdate(Request $request, $formID)
    {
        $assessment = Assessment::findOrFail($formID);

        $request->validate([
            'patient_id' => 'required|exists:patient,patientID',
            'attendedBy' => 'required|string',
            'prescribedBy' => 'required|string',
        ]);

        $dialysisDaysString = is_array($request->dialysisDay) ? implode(',', $request->dialysisDay) : null;

        $assessment->update([
            'patientID' => $request->patient_id,
            'hospital' => $request->hospital,
            'footSize' => $request->footSize,
            'linerSize' => $request->linerSize,
            'prosthesisNo' => $request->prosthesisNo,
            'reasonAmputation' => $request->reasonAmputation,
            'patientAssessment' => $request->patientAssessment,
            'dialysisDay' => $dialysisDaysString,
            'componentSuggestions' => $request->componentSuggestions,
            'attendedBy' => $request->attendedBy,
            'prescribedBy' => $request->prescribedBy,
            'receiveDate' => $request->receiveDate,
        ]);

        return redirect()->route('staff.assessment.list')->with('success', 'Assessment updated successfully!');
    }

    public function staffDestroy($formID)
    {
        Assessment::findOrFail($formID)->delete();
        return redirect()->route('staff.assessment.list')->with('success', 'Assessment deleted successfully!');
    }

    public function getPatientInfo($patientID)
    {
        $patient = Patient::findOrFail($patientID);
        return response()->json([
            'patientIC' => $patient->patientIC,
            'patientTel' => $patient->patientTel
        ]);
    }
}
