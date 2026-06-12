<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Hapus baris WhatsappService di sini karena tidak digunakan di halaman Alumni

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
        
        $alumni = Auth::user()->alumni;
        $sudahMelamar = false;
        
        if ($alumni) {
            $sudahMelamar = Lamaran::where('alumni_id', $alumni->id)
                                   ->where('lowongan_id', $id)
                                   ->exists();
        }

        return view('alumni.lowongan.show', compact('lowongan', 'sudahMelamar'));
    }

    public function apply(Request $request, $id)
    {
        $alumni = Auth::user()->alumni;

        if (!$alumni) {
            return redirect()->back()->with('error', 'Profil alumni tidak ditemukan.');
        }

        // Validasi dengan Pesan Error Bahasa Indonesia
        $request->validate([
            'surat_lamaran' => 'required|string|min:30',
            'file_cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'surat_lamaran.required' => 'Surat lamaran wajib diisi.',
            'surat_lamaran.min'      => 'Surat lamaran harus terdiri dari minimal 30 karakter.',
            'file_cv.mimes'          => 'Format CV harus berupa PDF, DOC, atau DOCX.',
            'file_cv.max'            => 'Ukuran file CV maksimal 5MB.',
        ]);

        // Cek apakah sudah melamar
        $sudahMelamar = Lamaran::where('alumni_id', $alumni->id)
                               ->where('lowongan_id', $id)
                               ->exists();

        if ($sudahMelamar) {
            return redirect()->back()->with('error', 'Anda sudah melamar lowongan ini sebelumnya.');
        }

        $data = [
            'alumni_id'      => $alumni->id,
            'lowongan_id'    => $id,
            'surat_lamaran'  => $request->surat_lamaran,
            'status_lamaran' => 'pending',
        ];

        // JURUS ULTIMATE: Bypass Flysystem Laravel, gunakan fungsi move() langsung!
        if ($request->hasFile('file_cv')) {
            $file = $request->file('file_cv');
            
            // Ambil ekstensi, jika gagal terbaca, paksa menjadi 'pdf'
            $ext = $file->getClientOriginalExtension() ?: 'pdf';
            $namaFile = 'cv_' . time() . '_' . uniqid() . '.' . $ext;
            
            // Tentukan jalur absolut (langsung menembak ke folder di komputer Anda)
            $tujuan_upload = storage_path('app/public/cv');
            
            // Pindahkan file secara paksa dan langsung
            $file->move($tujuan_upload, $namaFile);
            
            // Simpan nama path ke database
            $data['file_cv'] = 'cv/' . $namaFile;
        }

        try {
            Lamaran::create($data);
            return redirect()->route('alumni.lamaran.index')
                ->with('success', 'Lamaran berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
        
    }
}