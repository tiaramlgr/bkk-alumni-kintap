<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\DokumenAlumni;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // DEBUG: Cek apakah user punya relasi alumni
        if (!$user->alumni) {
            return redirect()->route('alumni.dashboard')
                ->with('error', 'Profil alumni Anda belum ditemukan. Silakan hubungi Admin untuk verifikasi.');
        }

        $dokumens = DokumenAlumni::where('alumni_id', $user->alumni->id)
                    ->latest()
                    ->get();

        return view('alumni.dokumen.index', compact('dokumens'));
    }

    // store method tetap sama
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->alumni) {
            return redirect()->route('alumni.dashboard')
                ->with('error', 'Profil alumni belum lengkap.');
        }

        $request->validate([
            'tipe_dokumen' => 'required|in:skhu,ijazah,transkrip,sertifikat',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $namaFile = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('public/dokumen', $namaFile);

        DokumenAlumni::create([
            'alumni_id' => $user->alumni->id,
            'tipe_dokumen' => $request->tipe_dokumen,
            'nama_file' => $file->getClientOriginalName(),
            'path_file' => 'dokumen/' . $namaFile,
            'tahun_dokumen' => date('Y'),
            'is_active' => false,
        ]);

        return redirect()->route('alumni.dokumen.index')
            ->with('success', 'Dokumen berhasil diupload!');
    }
}