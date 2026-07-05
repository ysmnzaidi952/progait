<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalRecordController;

Route::group([
    'prefix' => '/doctor',
    'middleware' => ['auth:doctor'],
    'as' => 'doctor.'
], function () {
    // Doctor dashboard
    Route::get('/dashboard', [DoctorController::class, 'indexdoctor'])->name('indexdoctor');

    // Patient routes accessible by doctor
    Route::get('/patient/list', [PatientController::class, 'indexDoctor'])->name('patientlistdoct');
    Route::get('/patient/view/{patientID}', [PatientController::class, 'showDoctor'])->name('patientviewdoct');
    Route::get('/patient/edit/{patientID}', [PatientController::class, 'showEditDoctor'])->name('patientupdatedoct');
    Route::put('/patient/update/{patientID}', [PatientController::class, 'updateDoctor'])->name('updatedoc');

    // Doctor appointment routes
    Route::group([
        'prefix' => '/appointment',
        'as' => 'appointment.'
    ], function () {
        Route::get('/list', [AppointmentController::class, 'doctorIndex'])->name('list');
        Route::get('/create', [AppointmentController::class, 'createDoctor'])->name('create');
        Route::post('/store', [AppointmentController::class, 'storeDoctor'])->name('store');
        Route::get('/check-slots/{date}', [AppointmentController::class, 'checkSlotsDoctor'])->name('check-slots');
        Route::get('/{appID}', [AppointmentController::class, 'showDoctor'])->name('show');
        Route::get('/{appID}/edit', [AppointmentController::class, 'editDoctor'])->name('edit');
        Route::put('/{appID}/update', [AppointmentController::class, 'updateDoctor'])->name('update');
        Route::put('/{appID}/cancel', [AppointmentController::class, 'cancelDoctor'])->name('cancel');
    });

    // Show the create form for doctor
    Route::get('/medical-records/create', [MedicalRecordController::class, 'doctorCreate'])->name('medical.create');
    // Handle the submission
    Route::post('/medical-records/store', [MedicalRecordController::class, 'store'])->name('medical.store');
    Route::get('/medical-records', [MedicalRecordController::class, 'doctorIndex'])->name('medical.list');
    Route::delete('/medical-records/{medID}/delete', [MedicalRecordController::class, 'destroyDoctor'])->name('medical.delete');


});
