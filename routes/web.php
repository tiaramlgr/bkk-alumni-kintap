<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterStepController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\LowonganController;

// Public
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registrasi
Route::get('/register/step1', [RegisterStepController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [RegisterStepController::class, 'processStep1']);
Route::get('/register/step2', [RegisterStepController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [RegisterStepController::class, 'processStep2']);
Route::get('/register/success', fn() => view('auth.register-success'))->name('register.success');

// Protected
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isAlumni()) return redirect()->route('alumni.dashboard');
        return redirect('/login');
    })->name('dashboard');

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::resource('lowongan', LowonganController::class)->except(['show','edit','update','destroy']);
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
        Route::post('/alumni/{id}/approve', [AlumniController::class, 'approve'])->name('alumni.approve');
        Route::post('/alumni/{id}/reject', [AlumniController::class, 'reject'])->name('alumni.reject');
        Route::resource('lowongan', LowonganController::class)
             ->only(['index', 'create', 'store']);
    });

    // Alumni
    Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', fn() => view('alumni.dashboard'))->name('dashboard');
    });
});