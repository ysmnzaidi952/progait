<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Staff;
use App\Models\Appointment;
use App\Models\Doctor;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();

        $recentPatients = Patient::latest()->get();


        return view('staff.indexstaff', compact(
            'totalPatients',
            'totalStaff',
            'totalDoctors',
            'recentPatients',
            'totalAppointments' // ✅ fix this one
        ));

    }
}
