<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // ===== ADMIN: Appointment List =====
    public function index()
    {
        $appointments = Appointment::with('patient')->orderBy('appointmentDate', 'asc')->paginate(10);

        $today = Carbon::today()->toDateString();
        $week = Carbon::today()->endOfWeek()->toDateString();

        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointmentDate', $today)->count();
        $weekAppointments = Appointment::whereBetween('appointmentDate', [Carbon::today(), $week])->count();

        return view('appointment.list', compact(
            'appointments',
            'totalAppointments',
            'todayAppointments',
            'weekAppointments'
        ));
    }

    // ===== ADMIN: Create Form =====
    public function createAdmin()
    {
        $patients = Patient::all();
        return view('appointment.create', compact('patients'));
    }

    // ===== ADMIN: Store Appointment =====
    public function storeAdmin(Request $request)
    {
        // Validate fields
        $this->validateAppointmentRequest($request);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled between Monday and Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Appointments must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime)) {
            return back()->with('error', 'The selected time slot overlaps with another appointment.');
        }

        Appointment::create([
            'patientID' => $request->patientID,
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'status' => 'upcoming',
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.appointment.list')->with('success', 'Appointment created successfully.');
    }

    // ===== ADMIN: Cancel Appointment =====
    public function cancelAdmin($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->route('admin.appointment.list')->with('success', 'Appointment cancelled.');
    }

    // ===== ADMIN: Edit Form =====
    public function editAdmin($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        return view('appointment.update', compact('appointment'));
    }

    // ===== ADMIN: Update Appointment =====
    public function updateAdmin(Request $request, $appID)
    {
        // Validate fields with status required
        $this->validateAppointmentRequest($request, true);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled Monday to Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Time must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime, $appID)) {
            return back()->with('error', 'This time slot is already booked.');
        }

        $appointment = Appointment::findOrFail($appID);
        $appointment->update([
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.appointment.list')->with('success', 'Appointment updated successfully.');
    }

    // ===== Doctor: Update Appointment =====
    public function updateDoctor(Request $request, $appID)
    {
        // Validate fields with status required
        $this->validateAppointmentRequest($request, true);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled Monday to Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Time must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime, $appID)) {
            return back()->with('error', 'This time slot is already booked.');
        }

        $appointment = Appointment::findOrFail($appID);
        $appointment->update([
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('doctor.appointment.list')->with('success', 'Appointment updated successfully.');
    }

    // ===== AJAX: Check Slot Availability =====
    public function checkSlots(Request $request, $date)
    {
        $excludeId = $request->query('exclude');

        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->where('status', '!=', 'cancelled')
            ->when($excludeId, fn($query) => $query->where('appID', '!=', $excludeId))
            ->get();

        $bookedSlots = [];
        foreach ($appointments as $appt) {
            $start = Carbon::createFromFormat('H:i:s', $appt->appointmentTime);
            $bookedSlots[] = ['start' => $start->hour];
        }

        return response()->json($bookedSlots);
    }

    public function storeDoctor(Request $request)
    {
        // Validate fields
        $this->validateAppointmentRequest($request);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled between Monday and Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Appointments must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime)) {
            return back()->with('error', 'The selected time slot overlaps with another appointment.');
        }

        Appointment::create([
            'patientID' => $request->patient_id, // ✅ Fixed: use patient_id from form
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'status' => 'upcoming',
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'notes' => $request->notes,
        ]);

        return redirect()->route('doctor.appointment.list')->with('success', 'Appointment created successfully.');
    }

    // ===== ADMIN Show Appointment =====
    public function showAdmin($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        // ✅ Fixed: Use patientID instead of patientIC
        $patientHistory = Appointment::where('patientID', $appointment->patientID)
            ->where('appID', '!=', $appointment->appID)
            ->orderBy('appointmentDate', 'desc')
            ->get();

        return view('appointment.view', compact('appointment', 'patientHistory'));
    }

    // ===== ADMIN: Print View =====
    public function printAdmin($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        return view('appointment.print', compact('appointment'));
    }

    // ===== ADMIN: Print View =====
    public function printDoctor($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        return view('appointment.print', compact('appointment'));
    }

    // ===== DOCTOR: Create Form =====
    public function createDoctor()
    {
        $patients = Patient::all();
        return view('appointment.createdoctor', compact('patients'));
    }

    public function editDoctor($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        return view('appointment.updatedoctor', compact('appointment'));
    }

    //doctor
    public function showDoctor($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        // ✅ Fixed: Use patientID instead of patientIC
        $patientHistory = Appointment::where('patientID', $appointment->patientID)
            ->where('appID', '!=', $appointment->appID)
            ->orderBy('appointmentDate', 'desc')
            ->get();

        return view('appointment.viewdoctor', compact('appointment', 'patientHistory'));
    }

    //doctor for cancellation
    public function cancelDoctor($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->route('doctor.appointment.list')->with('success', 'Appointment cancelled.');
    }

    // ===== DOCTOR: Appointment List =====
    public function doctorIndex()
    {
        $appointments = Appointment::with('patient')->orderBy('appointmentDate', 'asc')->paginate(10);

        $today = Carbon::today()->toDateString();
        $week = Carbon::today()->endOfWeek()->toDateString();

        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointmentDate', $today)->count();
        $weekAppointments = Appointment::whereBetween('appointmentDate', [Carbon::today(), $week])->count();

        return view('appointment.listdoctor', compact(
            'appointments',
            'totalAppointments',
            'todayAppointments',
            'weekAppointments'
        ));
    }

    public function checkSlotsDoctor(Request $request, $date)
    {
        $excludeId = $request->query('exclude');

        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->where('status', '!=', 'cancelled')
            ->when($excludeId, fn($query) => $query->where('appID', '!=', $excludeId))
            ->get();

        $bookedSlots = [];
        foreach ($appointments as $appt) {
            $start = Carbon::createFromFormat('H:i:s', $appt->appointmentTime);
            $bookedSlots[] = ['start' => $start->hour];
        }

        return response()->json($bookedSlots);
    }

    // ===== STAFF: Store Appointment =====
    public function storeStaff(Request $request)
    {
        $this->validateAppointmentRequest($request);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled between Monday and Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Appointments must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime)) {
            return back()->with('error', 'The selected time slot overlaps with another appointment.');
        }

        Appointment::create([
            'patientID' => $request->patient_id, // ✅ Fixed: use patient_id from form
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'status' => 'upcoming',
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.appointment.list')->with('success', 'Appointment created successfully.');
    }

    // ===== STAFF: Update Appointment =====
    public function updateStaff(Request $request, $appID)
    {
        $this->validateAppointmentRequest($request, true);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled Monday to Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Time must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime, $appID)) {
            return back()->with('error', 'This time slot is already booked.');
        }

        $appointment = Appointment::findOrFail($appID);
        $appointment->update([
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('staff.appointment.list')->with('success', 'Appointment updated successfully.');
    }

    // ===== STAFF: Cancel Appointment =====
    public function cancelStaff($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->route('staff.appointment.list')->with('success', 'Appointment cancelled.');
    }

    // ===== STAFF: List Appointments =====
    public function staffIndex()
    {
        $appointments = Appointment::orderBy('appointmentDate', 'asc')->paginate(10);

        $today = Carbon::today()->toDateString();
        $week = Carbon::today()->endOfWeek()->toDateString();

        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointmentDate', $today)->count();
        $weekAppointments = Appointment::whereBetween('appointmentDate', [Carbon::today(), $week])->count();

        return view('appointment.liststaff', compact(
            'appointments',
            'totalAppointments',
            'todayAppointments',
            'weekAppointments'
        ));
    }

    // ===== STAFF: Show Appointment =====
    public function showStaff($appID)
    {
        $appointment = Appointment::findOrFail($appID);

        // ✅ Fixed: Use patientID instead of patientIC
        $patientHistory = Appointment::where('patientID', $appointment->patientID)
            ->where('appID', '!=', $appointment->appID)
            ->orderBy('appointmentDate', 'desc')
            ->get();

        return view('appointment.viewstaff', compact('appointment', 'patientHistory'));
    }

    // ===== STAFF: Edit Appointment =====
    public function editStaff($appID)
    {
        $appointment = Appointment::findOrFail($appID);
        return view('appointment.updatestaff', compact('appointment'));
    }

    // ===== STAFF: Check Slots (AJAX) =====
    public function checkSlotsStaff(Request $request, $date)
    {
        $excludeId = $request->query('exclude');

        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->where('status', '!=', 'cancelled')
            ->when($excludeId, fn($query) => $query->where('appID', '!=', $excludeId))
            ->get();

        $bookedSlots = [];
        foreach ($appointments as $appt) {
            $start = Carbon::createFromFormat('H:i:s', $appt->appointmentTime);
            $bookedSlots[] = ['start' => $start->hour];
        }

        return response()->json($bookedSlots);
    }

    // ===== STAFF: Create Appointment Form =====
    public function createStaff()
    {
        $patients = Patient::all();
        return view('appointment.createstaff', compact('patients'));
    }

    // Show create appointment form for patient
    public function createPatient()
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $patient = Auth::guard('patient')->user();

        return view('appointment.createpatient', compact('patient'));
    }

    // Store appointment from patient form
    public function storePatient(Request $request)
    {
        $this->validateAppointmentRequest($request);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->appointmentDate . ' ' . $request->appointmentTime);
        $end = $start->copy()->addHours(2);

        if ($start->isWeekend()) {
            return back()->with('error', 'Appointments must be scheduled Monday to Friday.');
        }

        if ($start->hour < 9 || $end->hour > 17 || ($end->hour == 17 && $end->minute > 0)) {
            return back()->with('error', 'Appointments must be between 9:00 AM and 5:00 PM.');
        }

        if ($this->isSlotConflict($request->appointmentDate, $request->appointmentTime)) {
            return back()->with('error', 'The selected time slot overlaps with another appointment.');
        }

        // ✅ Fixed: Get patient ID from authenticated user
        $patientID = Auth::guard('patient')->user()->patientID;

        Appointment::create([
            'patientID' => $patientID,
            'typeAmputee' => $request->typeAmputee,
            'hospitalRefer' => $request->hospitalRefer,
            'sponsor' => $request->sponsor,
            'nextHospitalAppointment' => $request->nextHospitalAppointment,
            'appointmentDate' => $request->appointmentDate,
            'appointmentTime' => $request->appointmentTime,
            'status' => 'upcoming',
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.appointment.list')->with('success', 'Appointment created successfully.');
    }

    // AJAX: Check booked slots for patient date selection
    public function checkSlotsPatient($date)
    {
        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->where('status', '!=', 'cancelled')
            ->get();

        $bookedSlots = [];
        foreach ($appointments as $appt) {
            $start = Carbon::createFromFormat('H:i:s', $appt->appointmentTime);
            $bookedSlots[] = ['start' => $start->hour];
        }

        return response()->json($bookedSlots);
    }

    public function listPatient()
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // ✅ Fixed: Use patientID instead of patientIC
        $patientID = Auth::guard('patient')->user()->patientID;

        $appointments = Appointment::where('patientID', $patientID)
            ->orderBy('appointmentDate', 'desc')
            ->paginate(10);

        $upcomingAppointments = Appointment::where('patientID', $patientID)->where('status', 'upcoming')->count();
        $completedAppointments = Appointment::where('patientID', $patientID)->where('status', 'completed')->count();
        $cancelledAppointments = Appointment::where('patientID', $patientID)->where('status', 'cancelled')->count();

        return view('appointment.listpatient', compact(
            'appointments',
            'upcomingAppointments',
            'completedAppointments',
            'cancelledAppointments'
        ));
    }

    private function validateAppointmentRequest(Request $request, $isUpdate = false)
    {
        $rules = [];

        // ✅ Fixed: Check for patient_id instead of patientID
        if ($request->has('patient_id')) {
            $rules['patient_id'] = 'required|exists:patient,patientID';
        } else {
            $rules['patientName'] = 'required|string';
            $rules['patientIC'] = 'required|digits:12';
            $rules['patientTel'] = 'required|string|max:15';
        }

        $rules += [
            'typeAmputee' => 'required|string',
            'hospitalRefer' => 'nullable|string',
            'sponsor' => 'nullable|string',
            'nextHospitalAppointment' => 'nullable|date',
            'appointmentDate' => 'required|date|after_or_equal:today',
            'appointmentTime' => 'required',
            'notes' => 'nullable|string',
        ];

        if ($isUpdate) {
            $rules['status'] = 'required|in:upcoming,completed,cancelled';
        }

        return $request->validate($rules);
    }

    // ======= PRIVATE: Check for time conflicts =======
    private function isSlotConflict($date, $time, $excludeId = null)
    {
        $start = Carbon::createFromFormat('Y-m-d H:i', "$date $time");
        $end = $start->copy()->addHours(2);

        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->where('status', '!=', 'cancelled')
            ->when($excludeId, fn($q) => $q->where('appID', '!=', $excludeId))
            ->get();

        foreach ($appointments as $appt) {
            $apptStart = Carbon::createFromFormat('H:i:s', $appt->appointmentTime);
            $apptEnd = $apptStart->copy()->addHours(2);

            if ($start < $apptEnd && $end > $apptStart) {
                return true;
            }
        }

        return false;
    }

    public function cancelPatient($appID, Request $request)
    {
        $appointment = Appointment::findOrFail($appID);

        // Optional: You can log cancellation reason if needed
        $reason = $request->cancelReason ?? 'No reason provided';

        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'Appointment already cancelled.');
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->route('patient.appointment.list')->with('success', 'Appointment cancelled successfully.');
    }

    public function showPatient($appID)
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('patient.login')->with('error', 'Please login first.');
        }

        $appointment = Appointment::findOrFail($appID);

        // ✅ Fixed: Use patientID instead of patientIC
        if ($appointment->patientID !== Auth::guard('patient')->user()->patientID) {
            abort(403); // Forbidden
        }

        return view('appointment.viewpatient', compact('appointment'));
    }
}