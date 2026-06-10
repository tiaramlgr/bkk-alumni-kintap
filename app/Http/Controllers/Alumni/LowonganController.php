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
        $lowongans = LowonganKerja::with('kategori')
                    ->where('status', 'aktif')
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

        $request->validate([
            'surat_lamaran' => 'required|string|min:30',
            'file_cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'alumni_id' => auth()->user()->alumni->id,
            'lowongan_id' => $id,
            'surat_lamaran' => $request->surat_lamaran,
            'status_lamaran' => 'pending',
        ];

        if ($request->hasFile('file_cv')) {
            $file = $request->file('file_cv');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/cv', $namaFile);
            $data['file_cv'] = 'cv/' . $namaFile;
        }

        Lamaran::create($data);

        return redirect()->route('alumni.lowongan.index')
            ->with('success', 'Lamaran berhasil dikirim! Silakan cek riwayat lamaran.');
    }
}