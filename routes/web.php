<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, SetLocale::SUPPORTED_LOCALES, true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('locale.switch');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('appointments', AppointmentController::class)->except(['show']);
    Route::patch('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::middleware('role:patient')->group(function () {
        Route::get('/patient/dashboard', [DashboardController::class, 'patient'])->name('patient.dashboard');
    });

    Route::middleware('role:doctor')->group(function () {
        Route::get('/doctor/dashboard', [DashboardController::class, 'doctor'])->name('doctor.dashboard');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/users/{role}', [AdminUserManagementController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{role}', [AdminUserManagementController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{role}/{user}', [AdminUserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{role}/{user}', [AdminUserManagementController::class, 'destroy'])->name('admin.users.destroy');
    });
});
