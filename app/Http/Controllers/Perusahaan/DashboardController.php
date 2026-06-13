<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Hitung Lowongan Aktif milik perusahaan ini
        $lowonganAktif = LowonganKerja::where('admin_id', $userId)
                                      ->where('status', 'aktif')
                                      ->count();

        // 2. Hitung Total Pelamar untuk lowongan milik perusahaan ini
        $totalPelamar = Lamaran::whereHas('lowongan', function ($query) use ($userId) {
            $query->where('admin_id', $userId);
        })->count();

        // 3. Hitung Lamaran Baru yang statusnya masih pending
        $lamaranBaru = Lamaran::whereHas('lowongan', function ($query) use ($userId) {
            $query->where('admin_id', $userId);
        })->where('status_lamaran', 'pending')
          ->count();

        // Kirim ketiga data ke view dashboard perusahaan
        return view('perusahaan.dashboard', compact('lowonganAktif', 'totalPelamar', 'lamaranBaru'));
    }
}