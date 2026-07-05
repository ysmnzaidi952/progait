<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/patient',
    'middleware' => ['auth:patient'],
    'as' => 'patient.'
], function () {
    Route::get('/indexpatient', [PatientController::class, 'indexpatient'])->name('indexpatient');

    Route::group([
        'prefix' => '/appointment',
        'as' => 'appointment.'
    ], function () {
        Route::get('/create', [AppointmentController::class, 'createPatient'])->name('create');
        Route::post('/store', [AppointmentController::class, 'storePatient'])->name('store');
        Route::get('/check-slots/{date}', [AppointmentController::class, 'checkSlotsPatient'])->name('check-slots');
        Route::get('/list', [AppointmentController::class, 'listPatient'])->name('list');
        Route::delete('/{appID}/cancel', [AppointmentController::class, 'cancelPatient'])->name('cancel');
        Route::get('/{appID}/show', [AppointmentController::class, 'showPatient'])->name('show');


    });

    Route::get('/profile', [PatientController::class, 'viewProfile'])->name('profile');
    Route::get('/profile/edit', [PatientController::class, 'editProfile'])->name('profile.edit');
    Route::put('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('profile.update');



});
