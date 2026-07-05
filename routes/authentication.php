<?php

use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLogin'])->name('login')->middleware('guest.all');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit')->middleware('guest.all');

// Logout route
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['auth:patient,staff,doctor,admin']);
