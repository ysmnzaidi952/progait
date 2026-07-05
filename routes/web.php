<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminDashboardController;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Doctor;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProstheticRecommendationController;

// Homepage
Route::get('/', function () {
    return view('index');
});



include('authentication.php');
include("patient.php");
include('doctor.php');
include('admin.php');
include('staff.php');



// Patient Registration/Login
Route::get('/patient/register', [PatientController::class, 'showRegister'])->name('patient.register');
Route::post('/patient/register', [PatientController::class, 'register']);


Route::get('/patient/login', [PatientController::class, 'showLogin'])->name('patient.login');
// Route::get('/patient/indexpatient', [PatientController::class, 'indexpatient'])->name('patient.indexpatient');
// Route::get('/patient/logout', [PatientController::class, 'logout'])->name('patient.logout');

// Staff/Admin Login (all handled by LoginController)

// Staff Registration (admin-only)
Route::get('/staff/register', [StaffController::class, 'showRegister'])->name('staff.register');
Route::post('/staff/register', [StaffController::class, 'register'])->name('staff.register.post');



// Doctor Registration
Route::get('/doctor/register', [DoctorController::class, 'showRegister'])->name('doctor.register.show');
Route::post('/doctor/register', [DoctorController::class, 'register'])->name('doctor.register');

Route::get('/staff/indexadmin', function () {
    return redirect()->route('admin.dashboard');
})->name('staff.indexadmin'); // ✅ Now it redirects properly

Route::get('/staff/indexstaff', function () {
    return redirect()->route('staff.dashboard');
})->name('staff.indexstaff');

// After login index pages
Route::get('/staff/indexstaff2', function () {
    return view('staff.indexstaff2');
})->name('staff.indexstaff2');

Route::get('/staff/indexadmin2', function () {
    return view('staff.indexadmin2');
})->name('staff.indexadmin2');

Route::get('/patient/indexpatient2', function () {
    return view('patient.indexpatient2');
})->name('patient.indexpatient2');

Route::get('/doctor/indexdoctor2', function () {
    return view('doctor.indexdoctor2');
})->name('doctor.indexdoctor2');

// Prosthetic Recommendation (doctor)
Route::get('/recommendation/{patientId}', [ProstheticRecommendationController::class, 'recommend'])->name('recommendation');
// admin
Route::get('/adminrecommendation/{patientId}', [ProstheticRecommendationController::class, 'adminRecommend'])->name('admin.recommendation');
//staff
Route::get('/staffrecommendation/{patientId}', [ProstheticRecommendationController::class, 'staffRecommend'])->name('staff.recommendation');





