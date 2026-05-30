<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use App\Models\Lamaran;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = LowonganKerja::where('status', 'aktif')
                    ->with('kategori')
                    ->latest()
                    ->paginate(9);

        return view('alumni.lowongan.index', compact('lowongans'));
    }

    public function show($id)
    {
        $lowongan = LowonganKerja::with('kategori')->findOrFail($id);
        return view('alumni.lowongan.show', compact('lowongan'));
    }

    public function apply(Request $request, $id)
    {
        $lowongan = LowonganKerja::findOrFail($id);

        // Cek apakah sudah pernah melamar
        $sudahMelamar = Lamaran::where('alumni_id', auth()->user()->alumni->id)
                        ->where('lowongan_id', $id)
                        ->exists();

        if ($sudahMelamar) {
            return back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        Lamaran::create([
            'alumni_id' => auth()->user()->alumni->id,
            'lowongan_id' => $id,
            'status_lamaran' => 'pending',
            'surat_lamaran' => $request->surat_lamaran,
        ]);

        return redirect()->route('alumni.dashboard')
            ->with('success', 'Lamaran berhasil dikirim!');
    }
}