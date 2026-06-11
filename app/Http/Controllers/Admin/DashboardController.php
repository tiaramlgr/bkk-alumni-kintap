<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Lamaran;
use App\Models\TracerStudy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Mengarahkan ke halaman Dashboard Utama
    public function index()
    {
        return view('admin.dashboard');
    }

    // Mengumpulkan dan mengarahkan ke halaman Activity Log
    public function activityLog()
    {
        // Log Pendaftaran Alumni
        $logAlumni = Alumni::with('user')->latest()->get()->map(function ($item) {
            return (object) [
                'icon'    => 'fa-user-plus',
                'color'   => 'text-blue-600',
                'bg'      => 'bg-blue-100',
                'pesan'   => 'Alumni baru mendaftar: <strong>' . ($item->user->name ?? 'Anonim') . '</strong>',
                'waktu'   => $item->created_at
            ];
        });

        // Log Lamaran Kerja
        $logLamaran = Lamaran::with(['alumni.user', 'lowongan'])->latest()->get()->map(function ($item) {
            return (object) [
                'icon'    => 'fa-paper-plane',
                'color'   => 'text-emerald-600',
                'bg'      => 'bg-emerald-100',
                'pesan'   => '<strong>' . ($item->alumni->user->name ?? 'Alumni') . '</strong> melamar pekerjaan di <strong>' . ($item->lowongan->judul_lowongan ?? 'Perusahaan') . '</strong>',
                'waktu'   => $item->created_at
            ];
        });

        // Log Pengisian Tracer Study
        $logTracer = TracerStudy::with('alumni.user')->latest('updated_at')->get()->map(function ($item) {
            return (object) [
                'icon'    => 'fa-graduation-cap',
                'color'   => 'text-purple-600',
                'bg'      => 'bg-purple-100',
                'pesan'   => '<strong>' . ($item->alumni->user->name ?? 'Alumni') . '</strong> memperbarui data Tracer Study.',
                'waktu'   => $item->updated_at
            ];
        });

        // Gabungkan Semua Log, Urutkan dari Terkini, Ambil 50 Teratas
        $activityLogs = $logAlumni->concat($logLamaran)->concat($logTracer)
                                  ->sortByDesc('waktu')->take(50);

        return view('admin.activity-log', compact('activityLogs'));
    }
}