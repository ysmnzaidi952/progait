<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\Staff\ProstheticComponentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReminderController;

Route::group([
    'prefix' => 'staff',
    'middleware' => ['auth:staff'],
    'as' => 'staff.'
], function () {

        // Route::get('/dashboard', function () {
        //     return view('staff.indexstaff');
        // })->name('indexstaff');

    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    
    // Patient
    Route::get('/patient/list', [PatientController::class, 'indexStaff'])->name('patient.patientliststaff');
    Route::get('/patient/view/{patientID}', [PatientController::class, 'showStaff'])->name('patient.patientviewstaff');
    Route::get('/patient/edit/{patientID}', [PatientController::class, 'showEditStaff'])->name('patient.patientupdatestaff');
    Route::put('/patient/update/{patientID}', [PatientController::class, 'updateStaff'])->name('patient.updatestaff');
    Route::delete('/patient/delete/{patientID}', [PatientController::class, 'destroyStaff'])->name('patient.deletestaff');

    // Appointment
    Route::prefix('appointment')->name('appointment.')->group(function () {
        Route::get('/list', [AppointmentController::class, 'staffIndex'])->name('list');
        Route::get('/create', [AppointmentController::class, 'createStaff'])->name('create');
        Route::post('/store', [AppointmentController::class, 'storeStaff'])->name('store');
        Route::get('/{appID}', [AppointmentController::class, 'showStaff'])->name('show');
        Route::get('/{appID}/edit', [AppointmentController::class, 'editStaff'])->name('edit');
        Route::put('/{appID}/update', [AppointmentController::class, 'updateStaff'])->name('update');
        Route::put('/{appID}/cancel', [AppointmentController::class, 'cancelStaff'])->name('cancel');
        Route::get('/check-slots/{date}', [AppointmentController::class, 'checkSlotsStaff'])->name('checkSlots');
    });

    // Assessment
    Route::get('/assessment/list', [AssessmentController::class, 'staffIndex'])->name('assessment.list');
    Route::get('/assessment/create', [AssessmentController::class, 'staffCreate'])->name('assessment.create');
    Route::post('/assessment/store', [AssessmentController::class, 'staffStore'])->name('assessment.store');
    Route::get('/assessment/{formID}', [AssessmentController::class, 'staffShow'])->name('assessment.show');
    Route::get('/assessment/{formID}/edit', [AssessmentController::class, 'staffEdit'])->name('assessment.edit');
    Route::put('/assessment/{formID}', [AssessmentController::class, 'staffUpdate'])->name('assessment.update');
    Route::delete('/assessment/{formID}', [AssessmentController::class, 'staffDestroy'])->name('assessment.destroy');
    Route::get('/assessment/patient-info/{formID}', [AssessmentController::class, 'getPatientInfo']);

    // Doctor
    Route::get('/doctor/list', [DoctorController::class, 'showDoctorListStaff'])->name('doctor.doctorliststaff');
    Route::get('/doctor/view/{docID}', [DoctorController::class, 'showDoctorViewStaff'])->name('doctor.viewstaff');
    Route::get('/doctor/edit/{docID}', [DoctorController::class, 'showDoctorEdit'])->name('doctor.editstaff');
    Route::post('/doctor/update/{docID}', [DoctorController::class, 'updateDoctorStaff'])->name('doctor.updatestaff');
    Route::delete('/doctor/delete/{docID}', [DoctorController::class, 'deleteDoctorStaff'])->name('doctor.deletestaff');

    // Prosthetic Component Management (Staff)
    Route::prefix('component')->name('component.')->group(function () {
        Route::get('/', [ProstheticComponentController::class, 'index'])->name('index');
        Route::get('/create', [ProstheticComponentController::class, 'create'])->name('create');
        Route::post('/', [ProstheticComponentController::class, 'store'])->name('store');
        Route::get('/{id}', [ProstheticComponentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProstheticComponentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProstheticComponentController::class, 'update'])->name('update');
        Route::post('/{id}/request-deletion', [ProstheticComponentController::class, 'requestDeletion'])->name('request-deletion');
        
        // Additional component routes for staff
        Route::get('/status/{status}', [ProstheticComponentController::class, 'showByStatus'])->name('status');
        Route::post('/{id}/submit-review', [ProstheticComponentController::class, 'submitForReview'])->name('submit-review');
        Route::get('/search/components', [ProstheticComponentController::class, 'search'])->name('search');
        Route::get('/active/list', [ProstheticComponentController::class, 'getActiveComponents'])->name('active');
        Route::get('/statistics/data', [ProstheticComponentController::class, 'getStatistics'])->name('statistics');
    });

    // Profile
    Route::get('/profile/view', [StaffController::class, 'viewStaffProfile'])->name('profile.view');
    Route::get('/profile/edit', [StaffController::class, 'editStaffProfile'])->name('profile.edit');
    Route::put('/profile/update', [StaffController::class, 'updateStaffProfile'])->name('profile.update');

    // Reminder routes for staff
    Route::prefix('reminder')->name('reminder.')->group(function () {
        Route::get('/create', [ReminderController::class, 'createStaff'])->name('create');
        Route::post('/store', [ReminderController::class, 'storeStaff'])->name('store');
        Route::get('/check-availability/{date}', [ReminderController::class, 'checkAvailabilityStaff']);
        Route::get('/booked-dates/{year}/{month}', [ReminderController::class, 'getBookedDatesStaff']);
        Route::get('/list', [ReminderController::class, 'indexStaff'])->name('list');
        Route::post('/send/{remID}', [ReminderController::class, 'sendStaff'])->name('send');
        Route::delete('/{remID}', [ReminderController::class, 'destroyStaff'])->name('destroy');
    });

});