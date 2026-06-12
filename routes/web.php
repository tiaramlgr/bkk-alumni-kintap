<?php

use Illuminate\Support\Facades\Route;

// ================= AUTH CONTROLLERS =================
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterStepController; // KHUSUS ALUMNI
use App\Http\Controllers\Auth\PerusahaanLoginController;
use App\Http\Controllers\Auth\PerusahaanRegisterController;

// ================= ADMIN CONTROLLERS =================
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\LowonganController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KategoriLowonganController;
use App\Http\Controllers\Admin\SiaranWaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DokumenAlumniController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\TracerStudyController as AdminTracerController;
use App\Http\Controllers\Admin\PerusahaanController;
// ================= ALUMNI CONTROLLERS =================
use App\Http\Controllers\Alumni\LowonganController as AlumniLowonganController;
use App\Http\Controllers\Alumni\DokumenController;
use App\Http\Controllers\Alumni\LamaranController;
use App\Http\Controllers\Alumni\ProfilController;
use App\Http\Controllers\Alumni\TracerStudyController as AlumniTracerController;

// =============== PERUSAHAAN CONTROLLERS ===============
use App\Http\Controllers\Perusahaan\LamaranController as PerusahaanLamaranController;


// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== AUTH UMUM (LOGIN) ====================
// Kita buat rute login ini fleksibel untuk siapa saja
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==================== REGISTER ALUMNI (2-STEP) ====================

// 1. Rute untuk menampilkan form (yang diketik di browser)
Route::get('/register', [RegisterStepController::class, 'showStep1'])->name('register');

// 2. RUTE PENYELAMAT (Tambahkan baris ini)
// Jika sistem nyasar ke /register/step1, otomatis kembalikan ke /register
Route::get('/register/step1', fn() => redirect()->route('register'));

// 3. Rute untuk menerima data form (POST)
Route::post('/register/step1', [RegisterStepController::class, 'processStep1'])->name('register.step1');

// 4. Rute Step 2
Route::get('/register/step2', [RegisterStepController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [RegisterStepController::class, 'processStep2'])->name('register.step2.post');
Route::get('/register/success', fn() => view('auth.register-success'))->name('register.success');

// ==================== PERUSAHAAN ROUTES ====================
Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
    Route::get('/register', [PerusahaanRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PerusahaanRegisterController::class, 'register'])->name('register.submit');
    
    // Perusahaan disarankan login lewat /login (umum), tapi kita biarkan ini jika ada link khusus
    Route::get('/login', [PerusahaanLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PerusahaanLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [PerusahaanLoginController::class, 'logout'])->name('logout');
});


// ==================== PROTECTED ROUTES (HARUS LOGIN) ====================
Route::middleware('auth')->group(function () {

    // Redirecterdasarkan Role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isAlumni()) return redirect()->route('alumni.dashboard');
        if ($user->isPerusahaan()) return redirect()->route('perusahaan.dashboard');
        return redirect('/login');
    })->name('dashboard');

    // ====================== PERUSAHAAN ======================
    Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
        Route::get('/dashboard', fn() => view('perusahaan.dashboard'))->name('dashboard');
        Route::resource('lowongan', App\Http\Controllers\Perusahaan\LowonganController::class);
        Route::get('/lamaran', [PerusahaanLamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/lamaran/{id}', [PerusahaanLamaranController::class, 'show'])->name('lamaran.show');
        Route::put('/lamaran/{id}/status', [PerusahaanLamaranController::class, 'updateStatus'])->name('lamaran.status');
    });

    // ====================== ADMIN ======================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/activity-log', [\App\Http\Controllers\Admin\DashboardController::class, 'activityLog'])->name('activity-log');

        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
        Route::get('/alumni/{id}', [AlumniController::class, 'show'])->name('alumni.show');
        Route::get('/alumni/{id}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/alumni/{id}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/alumni/{id}', [AlumniController::class, 'destroy'])->name('alumni.destroy');
        Route::post('/alumni/{id}/approve', [AlumniController::class, 'approve'])->name('alumni.approve');
        Route::post('/alumni/{id}/reject', [AlumniController::class, 'reject'])->name('alumni.reject');

        Route::resource('perusahaan', \App\Http\Controllers\Admin\PerusahaanController::class);
        // Rute Kelola Perusahaan (Tanpa fitur tambah data)
        Route::resource('perusahaan', \App\Http\Controllers\Admin\PerusahaanController::class)->except(['create', 'store']);
        Route::resource('lowongan', LowonganController::class);
        Route::get('lowongan/{id}/pelamar', [LowonganController::class, 'pelamar'])->name('lowongan.pelamar');
        Route::post('lamaran/{id}/status', [LowonganController::class, 'updateStatusLamaran'])->name('lamaran.status');
        
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kategori-lowongan', KategoriLowonganController::class);
        Route::resource('tracer', AdminTracerController::class);
        
        Route::post('/siaran-wa/{id}/send', [SiaranWaController::class, 'send'])->name('siaran.send');
        Route::resource('siaran-wa', SiaranWaController::class)->names('siaran');  

        Route::resource('dokumen', DokumenAlumniController::class);
        Route::resource('berita', BeritaController::class);
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        
        Route::get('/export/alumni', [ExportController::class, 'alumni'])->name('export.alumni');
        Route::get('/export/tracer-study', [ExportController::class, 'tracerStudy'])->name('export.tracer');
        Route::get('/export/lowongan', [ExportController::class, 'lowongan'])->name('export.lowongan');
    });
    
    // ====================== ALUMNI ======================
    Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', fn() => view('alumni.dashboard'))->name('dashboard');
        
        Route::get('/lowongan', [AlumniLowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/lowongan/{id}', [AlumniLowonganController::class, 'show'])->name('lowongan.show');
        Route::post('/lowongan/{id}/apply', [AlumniLowonganController::class, 'apply'])->name('lowongan.apply');

        Route::get('/lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
        Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');

        Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

        Route::get('/tracer-study', [AlumniTracerController::class, 'index'])->name('tracer.index');
        Route::get('/tracer-study/create', [AlumniTracerController::class, 'create'])->name('tracer.create');
        Route::post('/tracer-study', [AlumniTracerController::class, 'store'])->name('tracer.store');
        Route::get('/tracer-study/edit', [AlumniTracerController::class, 'edit'])->name('tracer.edit');
        // Contoh rute untuk tracer study
        Route::get('/alumni/tracer-study/edit', [AlumniTracerController::class, 'edit'])->name('alumni.tracer-study.edit');
        Route::put('/tracer-study', [AlumniTracerController::class, 'update'])->name('tracer.update');
    });
});