<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Staff;
use App\Models\Doctor;
use App\Models\Appointment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();
        $totalAppointment = Appointment::count();

        
 
        $recentPatients = Patient::latest()->get();

        return view('staff.indexadmin', compact(
            'totalPatients',
            'totalStaff',
            'totalDoctors',
            'recentPatients',
            'totalAppointment'
        ));
    }
}

