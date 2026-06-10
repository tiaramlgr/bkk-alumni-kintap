<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterStepController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\LowonganController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KategoriLowonganController;
use App\Http\Controllers\Admin\SiaranWaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DokumenAlumniController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Alumni\LowonganController as AlumniLowonganController;
use App\Http\Controllers\Alumni\DokumenController;
use App\Http\Controllers\Alumni\LamaranController;
use App\Http\Controllers\Alumni\ProfilController;
use App\Http\Controllers\Alumni\TracerStudyController;
use App\Http\Controllers\Perusahaan\LamaranController as PerusahaanLamaranController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== PERUSAHAAN ROUTES ====================
Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
    Route::get('/register', [App\Http\Controllers\Auth\PerusahaanRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\PerusahaanRegisterController::class, 'register']);
    
    Route::get('/login', [App\Http\Controllers\Auth\PerusahaanLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\PerusahaanLoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Auth\PerusahaanLoginController::class, 'logout'])->name('logout');
});

    Route::prefix('perusahaan')->name('perusahaan.')->middleware('auth')->group(function () {
        Route::get('/dashboard', fn() => view('perusahaan.dashboard'))->name('dashboard');
        Route::resource('lowongan', App\Http\Controllers\Perusahaan\LowonganController::class)->only(['index', 'create', 'store']);
        Route::get('/lamaran', [App\Http\Controllers\Perusahaan\LamaranController::class, 'index'])->name('lamaran.index');
    });

// Auth Routes (Umum)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Multi-Step Registration Alumni
Route::get('/register/step1', [RegisterStepController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [RegisterStepController::class, 'processStep1']);
Route::get('/register/step2', [RegisterStepController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [RegisterStepController::class, 'processStep2']);
Route::get('/register/success', fn() => view('auth.register-success'))->name('register.success');

// ==================== PROTECTED ROUTES ====================
Route::middleware('auth')->group(function () {

    // Redirect Dashboard Berdasarkan Role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAlumni()) {
            return redirect()->route('alumni.dashboard');
        } elseif ($user->isPerusahaan()) {
            return redirect()->route('perusahaan.dashboard');
        }
        
        return redirect('/login');
    })->name('dashboard');

    // ====================== PERUSAHAAN ======================
    Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
        Route::get('/dashboard', fn() => view('perusahaan.dashboard'))->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\Auth\PerusahaanLoginController::class, 'logout'])->name('logout');
        Route::get('/lamaran', [PerusahaanLamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/lamaran/{id}', [PerusahaanLamaranController::class, 'show'])->name('lamaran.show');
        Route::put('/lamaran/{id}/status', [PerusahaanLamaranController::class, 'updateStatus'])->name('lamaran.status');
    });

    // ====================== ADMIN ======================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
        Route::get('/alumni/{id}', [AlumniController::class, 'show'])->name('alumni.show');
        Route::get('/alumni/{id}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/alumni/{id}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/alumni/{id}', [AlumniController::class, 'destroy'])->name('alumni.destroy');
        Route::post('/alumni/{id}/approve', [AlumniController::class, 'approve'])->name('alumni.approve');
        Route::post('/alumni/{id}/reject', [AlumniController::class, 'reject'])->name('alumni.reject');

        Route::resource('lowongan', LowonganController::class);
        // Rute khusus untuk melihat pelamar di sebuah lowongan
        Route::get('lowongan/{id}/pelamar', [App\Http\Controllers\Admin\LowonganController::class, 'pelamar'])->name('lowongan.pelamar');
        // Rute untuk mengupdate status lamaran (Approve/Reject)
        Route::post('lamaran/{id}/status', [App\Http\Controllers\Admin\LowonganController::class, 'updateStatusLamaran'])->name('lamaran.status');
        Route::resource('alumni', AlumniController::class)->except(['create', 'store']);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kategori-lowongan', KategoriLowonganController::class);
        
        // Siaran WhatsApp
        Route::resource('siaran-wa', SiaranWaController::class)->names('siaran');
        
        Route::resource('dokumen', DokumenAlumniController::class);

        Route::resource('berita', BeritaController::class);

        Route::resource('dokumen-alumni', DokumenAlumniController::class);

        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::get('/export/alumni', [ExportController::class, 'alumni'])->name('export.alumni');
        Route::get('/export/tracer-study', [ExportController::class, 'tracerStudy'])->name('export.tracer');
        Route::get('/export/lowongan', [ExportController::class, 'lowongan'])->name('export.lowongan');

        // EXPORT ROUTE (Tambahan baru)
        Route::get('/export/alumni', [App\Http\Controllers\Admin\ExportController::class, 'alumni'])->name('export.alumni');

        //kirim tombol wa
        Route::post('/siaran-wa/{id}/send', [SiaranWaController::class, 'send'])->name('siaran.send');
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

        Route::get('/tracer-study', [TracerStudyController::class, 'edit'])->name('tracer.edit');
        Route::put('/tracer-study', [TracerStudyController::class, 'update'])->name('tracer.update');
    });
});