<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ProstheticRecommendationController;
use App\Http\Controllers\ProstheticComponentController;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:admin'],
    'as' => 'admin.'
], function () {

    //profile view
    Route::get('/profile', [StaffController::class, 'profileView'])->name('staff.profile.view')->middleware('auth:admin');
    Route::put('/profile/update', [StaffController::class, 'profileUpdate'])->name('staff.profile.update')->middleware('auth:admin');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/approve-staff', [StaffController::class, 'showPendingStaff'])->name('show-approve-list');
    Route::patch('/approve-staff/{staffID}', [StaffController::class, 'approveStaff'])->name('approve-staff');

    Route::get('/approve-doctors', [DoctorController::class, 'showPendingDoctors'])->name('show-approve-doctor-list');
    Route::patch('/approve-doctor/{docID}', [DoctorController::class, 'approveDoctor'])->name('approve-doctor');

    // Staff
    Route::get('/staff/list', [StaffController::class, 'showAllStaff'])->name('stafflist');
    Route::get('/staff/edit/{staffID}', [StaffController::class, 'showStaffEdit'])->name('staff.edit');
    Route::put('/staff/update/{staffID}', [StaffController::class, 'updateStaff'])->name('staff.update');
    Route::delete('/staff/delete/{staffID}', [StaffController::class, 'deleteStaff'])->name('staff.delete');
    Route::get('/staff/view/{staffID}', [StaffController::class, 'showStaffView'])->name('staff.view');

    // Patient
    Route::get('/patient/list', [PatientController::class, 'indexAdmin'])->name('patient.patientlist');
    Route::get('/patient/view/{patientID}', [PatientController::class, 'show'])->name('patient.patientview');
    Route::get('/patient/edit/{patientID}', [PatientController::class, 'showEdit'])->name('patient.patientupdate');
    Route::put('/patient/update/{patientID}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/patient/delete/{patientID}', [PatientController::class, 'destroy'])->name('patient.delete');

    Route::prefix('appointment')->name('appointment.')->group(function () {
        Route::get('/list', [AppointmentController::class, 'index'])->name('list');
        Route::get('/create', [AppointmentController::class, 'createAdmin'])->name('create');  
        Route::get('/{appID}', [AppointmentController::class, 'showAdmin'])->name('show');
        Route::put('/{appID}/update', [AppointmentController::class, 'updateAdmin'])->name('update');
        Route::get('/{appID}/edit', [AppointmentController::class, 'editAdmin'])->name('edit');
        Route::put('/{appID}/cancel', [AppointmentController::class, 'cancelAdmin'])->name('cancel');
        Route::post('/store', [AppointmentController::class, 'storeAdmin'])->name('store');
        Route::get('/check-slots/{date}', [AppointmentController::class, 'checkSlots'])->name('check-slots');
        Route::get('/{appID}/print', [AppointmentController::class, 'printAdmin'])->name('print');
    });

    // Assessment
    Route::get('/assessment/list', [AssessmentController::class, 'index'])->name('assessment.list');
    Route::get('/assessment/create', [AssessmentController::class, 'create'])->name('assessment.create');
    Route::post('/assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::get('/assessment/{formID}', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::get('/assessment/{formID}/edit', [AssessmentController::class, 'edit'])->name('assessment.edit');
    Route::put('/assessment/{formID}', [AssessmentController::class, 'update'])->name('assessment.update');
    Route::delete('/assessment/{formID}', [AssessmentController::class, 'destroy'])->name('assessment.destroy');
    Route::get('/assessment/patient-info/{patientID}', [AssessmentController::class, 'getPatientInfo']);

    // Doctor
    Route::get('/doctor/list', [DoctorController::class, 'showDoctorList'])->name('doctor.doctorlist');
    Route::get('/doctor/view/{docID}', [DoctorController::class, 'showDoctorView'])->name('doctor.view');
    Route::get('/doctor/edit/{docID}', [DoctorController::class, 'showDoctorEdit'])->name('doctor.edit');
    Route::put('/doctor/update/{docID}', [DoctorController::class, 'updateDoctor'])->name('doctor.update');
    Route::delete('/doctor/delete/{docID}', [DoctorController::class, 'deleteDoctor'])->name('doctor.delete');

    //profile view
    Route::get('/admin/profile', [StaffController::class, 'profile'])->name('profile.edit'); // for edit page
    Route::put('/admin/profile/update', [StaffController::class, 'updateProfile'])->name('profile.update');
    Route::get('/admin/profile/view', [StaffController::class, 'adminViewProfile'])->name('profile.view'); // for view page

    //medical record
    Route::post('/medical/store', [MedicalRecordController::class, 'store'])->name('medical.store');
    Route::get('/medical/create', [MedicalRecordController::class, 'create'])->name('medical.create');
    Route::put('/medical/update/{medID}', [MedicalRecordController::class, 'update'])->name('medical.update');
    Route::delete('/medical/{medID}', [MedicalRecordController::class, 'destroy'])->name('medical.delete');
    Route::get('/medical/view/{medID}', [MedicalRecordController::class, 'view'])->name('medical.view');
    Route::get('/medical/list', [MedicalRecordController::class, 'adminList'])->name('medical.list');
    Route::get('/medical/edit/{medID}', [MedicalRecordController::class, 'edit'])->name('medical.edit');

    // Prosthetic Components - Complete CRUD
    Route::prefix('component')->name('component.')->group(function () {
        // Main CRUD Routes
        Route::get('/', [ProstheticComponentController::class, 'index'])->name('index');
        Route::get('/create', [ProstheticComponentController::class, 'create'])->name('create');
        Route::post('/store', [ProstheticComponentController::class, 'store'])->name('store');
        Route::get('/{id}', [ProstheticComponentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProstheticComponentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProstheticComponentController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProstheticComponentController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/restore', [ProstheticComponentController::class, 'restore'])->name('restore');
        
        // Additional API & Utility Routes
        Route::get('/api/active', [ProstheticComponentController::class, 'getActiveComponents'])->name('api.active');
        Route::post('/search', [ProstheticComponentController::class, 'search'])->name('search');
        Route::get('/api/statistics', [ProstheticComponentController::class, 'getStatistics'])->name('api.statistics');
        Route::post('/bulk-action', [ProstheticComponentController::class, 'bulkAction'])->name('bulk.action');
    });

    // Reminder
    Route::prefix('reminder')->name('reminder.')->group(function () {
        Route::get('/create', [ReminderController::class, 'create'])->name('create');
        Route::post('/store', [ReminderController::class, 'store'])->name('store');
        Route::get('/check-availability/{date}', [ReminderController::class, 'checkAvailability']);
        Route::get('/booked-dates/{year}/{month}', [ReminderController::class, 'getBookedDates']);
        Route::get('/list', [ReminderController::class, 'index'])->name('list');
        Route::post('/send/{remID}', [ReminderController::class, 'send'])->name('send');
        // Route::post('/send/{id}', function ($remID) {
        //     return 'Got ID: ' . $remID;
        // })->name('send');
    });
});