<?php

namespace App\Http\Controllers;

use App\Models\LowonganKerja;
use App\Models\Lamaran;
use App\Models\Berita;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LandingController extends Controller
{
    public function index()
    {
        // 1. Ambil 6 lowongan terbaru
        $lowongans = LowonganKerja::with('kategori')
                        ->where('status', 'aktif')
                        ->latest()
                        ->take(6)
                        ->get();

        // 2. Ambil data pengumuman (lamaran diterima)
        $pengumumans = Lamaran::with(['alumni.user', 'alumni.jurusan', 'lowongan'])
                        ->where('status_lamaran', 'diterima')
                        ->latest()
                        ->take(10)
                        ->get();

        // 3. AMBIL BERITA YANG STATUSNYA PUBLISHED (Maksimal 3 terbaru)
        $beritas = Berita::with('admin')
                        ->where('status', 'published')
                        ->latest()
                        ->take(3)
                        ->get();

        // Kirim ketiga data tersebut ke welcome.blade.php
        return view('welcome', compact('lowongans', 'pengumumans', 'beritas'));
    }

    public function cetakPdf()
    {
        $pengumumans = Lamaran::with(['alumni.user', 'alumni.jurusan', 'lowongan'])
                        ->where('status_lamaran', 'diterima')
                        ->latest()
                        ->get();

        $pdf = Pdf::loadView('pengumuman_pdf', compact('pengumumans'));
        return $pdf->download('Pengumuman_Lolos_Seleksi_BKK.pdf');
    }
}